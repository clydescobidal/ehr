package main

import (
	"embed"

	"database/sql"

	"fmt"
	"net/http"
	"os"

	_ "github.com/mattn/go-sqlite3"
	"github.com/wailsapp/wails/v2"
	"github.com/wailsapp/wails/v2/pkg/options"
	"github.com/wailsapp/wails/v2/pkg/options/assetserver"
)

//go:embed all:frontend/dist
var assets embed.FS

type FileLoader struct {
	http.Handler
}

func NewFileLoader() *FileLoader {
	return &FileLoader{}
}

func (h *FileLoader) ServeHTTP(res http.ResponseWriter, req *http.Request) {
	var err error
	//requestedFilename := strings.TrimPrefix(req.URL.Path, "/")
	requestedFilename := req.URL.Path
	fileData, err := os.ReadFile(requestedFilename)
	if err != nil {
		res.WriteHeader(http.StatusBadRequest)
		res.Write([]byte(fmt.Sprintf("Could not load file %s", requestedFilename)))
	}

	res.Write(fileData)
}

func main() {
	db, err := sql.Open("sqlite3", "./pos.db")
	if err != nil {
		panic(err)
	}
	defer db.Close()

	sqlStmt := []string{
		"CREATE TABLE IF NOT EXISTS auth (token string not null);",
		"CREATE TABLE IF NOT EXISTS menu_categories (id string not null primary key, name string, `order` integer);",
		"CREATE TABLE IF NOT EXISTS menu_items (id string not null primary key, name text, menu_category_id string, price real, thumbnail string);",
		"CREATE INDEX IF NOT EXISTS menu_item_name_idx ON menu_items (name);",
		"CREATE TABLE IF NOT EXISTS tables (id string not null primary key, name text);",
		"CREATE TABLE IF NOT EXISTS orders (id string not null primary key, table_id string, check_in_id string, paid_at text);",
		"CREATE TABLE IF NOT EXISTS order_tabs (id string not null primary key, order_id string, created_at string);",
		"CREATE TABLE IF NOT EXISTS order_tab_menu_items (order_tab_id string, menu_item_id string, price real, quantity int, name text, price real, thumbnail string);",
		"CREATE TABLE IF NOT EXISTS reservations (id string, guest_name string, room_id string, `from` string, `to` string);",
		"CREATE TABLE IF NOT EXISTS check_ins (id string, guest_name string, `from` string, `to` string, reservation_id string);",
	}

	for _, stmt := range sqlStmt {
		_, err = db.Exec(stmt)
		if err != nil {
			panic(err)
		}
	}

	// defer rows.Close()

	app := NewApp(db)

	// Create application with options
	err = wails.Run(&options.App{
		Title: "POS",
		//WindowStartState: options.Maximised,
		Frameless: false,
		Width:     1024,
		Height:    768,
		AssetServer: &assetserver.Options{
			Assets:  assets,
			Handler: NewFileLoader(),
		},
		BackgroundColour: &options.RGBA{R: 27, G: 38, B: 54, A: 1},
		OnStartup:        app.startup,
		Bind: []interface{}{
			app,
		},
	})

	if err != nil {
		println("Error:", err.Error())
	}
}
