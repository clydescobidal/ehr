package main

import (
	"context"
	"database/sql"
)

// App struct
type App struct {
	ctx context.Context
	db  *sql.DB
}

// NewApp creates a new App application struct
func NewApp(db *sql.DB) *App {
	return &App{
		db: db,
	}
}

func (a *App) startup(ctx context.Context) {
	a.ctx = ctx
}

type MenuCategory struct {
	Id    string
	Name  string
	Order int
}

func (a *App) GetMenuCategories() ([]MenuCategory, error) {
	rows, err := a.db.Query("SELECT `id`, `name`, `order` FROM menu_categories ORDER BY `order`")
	if err != nil {
		return []MenuCategory{}, err
	}

	defer rows.Close()

	var menu_categories []MenuCategory
	for rows.Next() {
		var menu_category MenuCategory
		err = rows.Scan(&menu_category.Id, &menu_category.Name, &menu_category.Order)
		if err != nil {
			return []MenuCategory{}, err
		}

		menu_categories = append(menu_categories, menu_category)
	}

	return menu_categories, nil
}

type Table struct {
	Id   string
	Name string
}

func (a *App) GetTables() ([]Table, error) {
	rows, err := a.db.Query("select id, name from tables")
	if err != nil {
		return []Table{}, err
	}

	defer rows.Close()

	var tables []Table
	for rows.Next() {
		var table Table
		err = rows.Scan(&table.Id, &table.Name)
		if err != nil {
			return []Table{}, err
		}

		tables = append(tables, table)
	}

	return tables, nil
}

type MenuItem struct {
	Id             string
	Name           string
	Price          float32
	Thumbnail      string
	MenuCategoryId string
}

type OrderTab struct {
	Id                string
	OrderId           string
	CreatedAt         string
	OrderTabMenuItems []OrderTabMenuItem
}

type Order struct {
	Id        string
	TableId   string
	CheckInId *string
	CreatedAt string
	OrderTabs []OrderTab
}

func (a *App) GetTableActiveOrder(table_id string) (Order, error) {
	row := a.db.QueryRow("SELECT `id`, `table_id`, `check_in_id`, `created_at` FROM `orders` WHERE `paid_at` IS NULL AND table_id = :table_id", sql.Named("table_id", table_id))

	if row != nil {
		var order Order
		err := row.Scan(&order.Id, &order.TableId, &order.CheckInId, &order.CheckInId)
		if err != nil {
			return Order{}, err
		}

		order_tabs, err := a.getOrderTabs(order)
		if err != nil {
			return Order{}, err
		}

		order.OrderTabs = order_tabs

		return order, nil
	}

	return Order{}, nil
}

func (a *App) getOrderTabs(order Order) ([]OrderTab, error) {
	rows, err := a.db.Query("SELECT `id`, `order_id`, `created_at` FROM `order_tabs` WHERE order_id = :order_id ORDER BY `created_at` DESC", sql.Named("order_id", order.Id))
	if err != nil {
		return []OrderTab{}, err
	}

	defer rows.Close()

	var order_tabs []OrderTab
	for rows.Next() {
		var order_tab OrderTab
		err = rows.Scan(&order_tab.Id, &order_tab.OrderId, &order_tab.CreatedAt)
		if err != nil {
			return []OrderTab{}, err
		}

		order_tab_menu_items, err := a.getOrderTabMenuItems(order_tab)
		if err != nil {
			return []OrderTab{}, err
		}
		order_tab.OrderTabMenuItems = order_tab_menu_items

		order_tabs = append(order_tabs, order_tab)
	}
	return order_tabs, nil
}

type OrderTabMenuItem struct {
	Price     float32
	Quantity  uint32
	Thumbnail string
	Name      string
}

func (a *App) getOrderTabMenuItems(orderTab OrderTab) ([]OrderTabMenuItem, error) {
	rows, err := a.db.Query("SELECT `price`, `quantity`, `name`, `thumbnail` FROM `order_tab_menu_items` WHERE order_tab_id = :order_tab_id", sql.Named("order_tab_id", orderTab.Id))
	if err != nil {
		return []OrderTabMenuItem{}, err
	}

	var order_tab_items []OrderTabMenuItem
	for rows.Next() {
		var order_tab_item OrderTabMenuItem
		err = rows.Scan(&order_tab_item.Price, &order_tab_item.Quantity, &order_tab_item.Name, &order_tab_item.Thumbnail)
		if err != nil {
			return []OrderTabMenuItem{}, err
		}

		order_tab_items = append(order_tab_items, order_tab_item)
	}

	return order_tab_items, nil
}
