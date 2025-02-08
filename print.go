package main

import (
	"bufio"
	"fmt"
	"image"
	"image/jpeg"
	"os"
	"time"
)

const (
	Width  int = 1
	Height int = 1
)
const (
	JustifyLeft                 uint8 = 0
	JustifyCenter               uint8 = 1
	JustifyRight                uint8 = 2
	QRCodeErrorCorrectionLevelL uint8 = 48
	QRCodeErrorCorrectionLevelM uint8 = 49
	QRCodeErrorCorrectionLevelQ uint8 = 50
	QRCodeErrorCorrectionLevelH uint8 = 51
	esc                         byte  = 0x1B
	gs                          byte  = 0x1D
	fs                          byte  = 0x1C
)
const (
	GS8L_MAX_Y = 1662
)

func main() {
	f, err := os.OpenFile("/dev/usb/lp0", os.O_RDWR, 0)
	if err != nil {
		panic(err)
	}
	defer f.Close()

	w := bufio.NewWriter(f)

	reader, err := os.Open("logo.jpg")
	if err != nil {
		panic(err)
	}
	defer reader.Close()
	image, err := jpeg.Decode(reader)
	if err != nil {
		panic(err)
	}

	currentTime := time.Now()

	w.WriteString(fmt.Sprintf("\x1Ba%c", 1)) // justify center
	PrintImage(w, image)
	w.Flush()

	w.WriteString((fmt.Sprintf("\x1BM%c", 0)))                       // font
	w.WriteString(fmt.Sprintf("\x1D!%c", ((Width-1)<<4)|(Height-1))) // font size
	w.WriteString(fmt.Sprintf("\x1Db%c", 2))                         // smooth
	w.Flush()

	w.WriteString("SEASEED RESORT")
	w.WriteString("\n")
	w.Flush()

	w.WriteString("BRY. LOCLOC, SAN LUIS, BATANGAS")
	w.WriteString("\n")
	w.WriteString("MOBILE: +639663363839")
	w.Write([]byte(fmt.Sprintf("\x1Bd%c", 2)))
	w.Flush()

	w.WriteString(fmt.Sprintf("\x1Ba%c", 0)) // justify left
	w.WriteString("DATE       " + currentTime.Format("2006-01-02 03:04:05PM"))
	w.WriteString("TRANSACTION ID            000001")
	w.WriteString("CASHIER                  PATCHIE")
	w.WriteString("TABLE NO                    0001")
	w.WriteString("ROOM NO                      002")
	w.WriteString("--------------------------------")
	w.WriteString("ITEM          QTY  PRICE  AMOUNT")
	w.WriteString("--------------------------------")
	w.WriteString("CHICKEN WINGS  1  259.00  259.00")
	w.WriteString("MANGO SHAKE    2  120.00  240.00")
	w.WriteString("LESS 20% SENIOR           -50.00")
	w.WriteString("--------------------------------")
	w.Write([]byte{esc, 'E', byte(1)}) // bold
	w.WriteString("TOTAL     3 ITEMS         550.00")
	w.Write([]byte{esc, 'E', byte(0)}) // regular
	w.WriteString("PAYMENT RECEIVED          500.00")
	w.WriteString("--------------------------------")
	w.WriteString("CHANGE                    120.00")
	w.WriteString("\n")
	w.Flush()

	w.WriteString(fmt.Sprintf("\x1Ba%c", 1)) // justify center
	w.Write([]byte(fmt.Sprintf("\x1Bd%c", 2)))
	w.WriteString("THANK YOU, PLEASE COME AGAIN!")
	w.WriteString("\n")
	w.WriteString("THIS IS AN UNOFFICIAL RECEIPT")
	w.WriteString("\n")
	w.Write([]byte(fmt.Sprintf("\x1Bd%c", 3)))
	w.Flush()

	w.Write([]byte(fmt.Sprintf("\x1Bd%c", 1)))
	w.Flush()
}

func PrintImage(w *bufio.Writer, img image.Image) {
	xL, xH, yL, yH, data := printImage(img)

	w.Write(append([]byte{gs, 'v', 48, 0, xL, xH, yL, yH}, data...))
	w.Flush()
}

func intLowHigh(input int, length int) string {
	output := ""

	for i := 0; i < length; i++ {
		output = output + string(byte(input%256))
		input = input / 256
	}

	return output
}

func printImage(img image.Image) (xL byte, xH byte, yL byte, yH byte, data []byte) {
	width, height, pixels := getPixels(img)

	removeTransparency(&pixels)
	makeGrayscale(&pixels)

	printWidth := closestNDivisibleBy8(width)
	printHeight := closestNDivisibleBy8(height)
	bytes, _ := rasterize(printWidth, printHeight, &pixels)

	return byte((printWidth >> 3) & 0xff), byte(((printWidth >> 3) >> 8) & 0xff), byte(printHeight & 0xff), byte((printHeight >> 8) & 0xff), bytes
}

func closestNDivisibleBy8(n int) int {
	q := n / 8
	n1 := q * 8

	return n1
}

func makeGrayscale(pixels *[][]pixel) {
	height := len(*pixels)
	width := len((*pixels)[0])

	for y := 0; y < height; y++ {
		row := (*pixels)[y]
		for x := 0; x < width; x++ {
			pixel := row[x]

			luminance := (float64(pixel.R) * 0.299) + (float64(pixel.G) * 0.587) + (float64(pixel.B) * 0.114)
			var value int
			if luminance < 128 {
				value = 0
			} else {
				value = 255
			}

			pixel.R = value
			pixel.G = value
			pixel.B = value

			row[x] = pixel
		}
	}
}

func removeTransparency(pixels *[][]pixel) {
	height := len(*pixels)
	width := len((*pixels)[0])

	for y := 0; y < height; y++ {
		row := (*pixels)[y]
		for x := 0; x < width; x++ {
			pixel := row[x]

			alpha := pixel.A
			invAlpha := 255 - alpha

			pixel.R = (alpha*pixel.R + invAlpha*255) / 255
			pixel.G = (alpha*pixel.G + invAlpha*255) / 255
			pixel.B = (alpha*pixel.B + invAlpha*255) / 255
			pixel.A = 255

			row[x] = pixel
		}
	}
}

func rasterize(printWidth int, printHeight int, pixels *[][]pixel) ([]byte, error) {
	if printWidth%8 != 0 {
		fmt.Println("1")
		return nil, fmt.Errorf("printWidth must be a multiple of 8")
	}

	if printHeight%8 != 0 {
		fmt.Println("2")
		return nil, fmt.Errorf("printHeight must be a multiple of 8")
	}

	bytes := make([]byte, (printWidth*printHeight)>>3)

	for y := 0; y < printHeight; y++ {
		for x := 0; x < printWidth; x = x + 8 {
			i := y*(printWidth>>3) + (x >> 3)
			bytes[i] =
				byte((getPixelValue(x+0, y, pixels) << 7) |
					(getPixelValue(x+1, y, pixels) << 6) |
					(getPixelValue(x+2, y, pixels) << 5) |
					(getPixelValue(x+3, y, pixels) << 4) |
					(getPixelValue(x+4, y, pixels) << 3) |
					(getPixelValue(x+5, y, pixels) << 2) |
					(getPixelValue(x+6, y, pixels) << 1) |
					getPixelValue(x+7, y, pixels))
		}
	}

	return bytes, nil
}

func getPixelValue(x int, y int, pixels *[][]pixel) int {
	row := (*pixels)[y]
	pixel := row[x]

	if pixel.R > 0 {
		return 0
	}

	return 1
}

func rgbaToPixel(r uint32, g uint32, b uint32, a uint32) pixel {
	return pixel{int(r >> 8), int(g >> 8), int(b >> 8), int(a >> 8)}
}

type pixel struct {
	R int
	G int
	B int
	A int
}

func getPixels(img image.Image) (int, int, [][]pixel) {

	bounds := img.Bounds()
	width, height := bounds.Max.X, bounds.Max.Y

	var pixels [][]pixel
	for y := 0; y < height; y++ {
		var row []pixel
		for x := 0; x < width; x++ {
			row = append(row, rgbaToPixel(img.At(x, y).RGBA()))
		}
		pixels = append(pixels, row)
	}

	return width, height, pixels
}
