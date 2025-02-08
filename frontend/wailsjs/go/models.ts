export namespace main {
	
	export class MenuCategory {
	    Id: string;
	    Name: string;
	    Order: number;
	
	    static createFrom(source: any = {}) {
	        return new MenuCategory(source);
	    }
	
	    constructor(source: any = {}) {
	        if ('string' === typeof source) source = JSON.parse(source);
	        this.Id = source["Id"];
	        this.Name = source["Name"];
	        this.Order = source["Order"];
	    }
	}
	export class OrderTabMenuItem {
	    Price: number;
	    Quantity: number;
	    Thumbnail: string;
	    Name: string;
	
	    static createFrom(source: any = {}) {
	        return new OrderTabMenuItem(source);
	    }
	
	    constructor(source: any = {}) {
	        if ('string' === typeof source) source = JSON.parse(source);
	        this.Price = source["Price"];
	        this.Quantity = source["Quantity"];
	        this.Thumbnail = source["Thumbnail"];
	        this.Name = source["Name"];
	    }
	}
	export class OrderTab {
	    Id: string;
	    OrderId: string;
	    CreatedAt: string;
	    OrderTabMenuItems: OrderTabMenuItem[];
	
	    static createFrom(source: any = {}) {
	        return new OrderTab(source);
	    }
	
	    constructor(source: any = {}) {
	        if ('string' === typeof source) source = JSON.parse(source);
	        this.Id = source["Id"];
	        this.OrderId = source["OrderId"];
	        this.CreatedAt = source["CreatedAt"];
	        this.OrderTabMenuItems = this.convertValues(source["OrderTabMenuItems"], OrderTabMenuItem);
	    }
	
		convertValues(a: any, classs: any, asMap: boolean = false): any {
		    if (!a) {
		        return a;
		    }
		    if (a.slice && a.map) {
		        return (a as any[]).map(elem => this.convertValues(elem, classs));
		    } else if ("object" === typeof a) {
		        if (asMap) {
		            for (const key of Object.keys(a)) {
		                a[key] = new classs(a[key]);
		            }
		            return a;
		        }
		        return new classs(a);
		    }
		    return a;
		}
	}
	export class Order {
	    Id: string;
	    TableId: string;
	    CheckInId?: string;
	    CreatedAt: string;
	    OrderTabs: OrderTab[];
	
	    static createFrom(source: any = {}) {
	        return new Order(source);
	    }
	
	    constructor(source: any = {}) {
	        if ('string' === typeof source) source = JSON.parse(source);
	        this.Id = source["Id"];
	        this.TableId = source["TableId"];
	        this.CheckInId = source["CheckInId"];
	        this.CreatedAt = source["CreatedAt"];
	        this.OrderTabs = this.convertValues(source["OrderTabs"], OrderTab);
	    }
	
		convertValues(a: any, classs: any, asMap: boolean = false): any {
		    if (!a) {
		        return a;
		    }
		    if (a.slice && a.map) {
		        return (a as any[]).map(elem => this.convertValues(elem, classs));
		    } else if ("object" === typeof a) {
		        if (asMap) {
		            for (const key of Object.keys(a)) {
		                a[key] = new classs(a[key]);
		            }
		            return a;
		        }
		        return new classs(a);
		    }
		    return a;
		}
	}
	
	
	export class Table {
	    Id: string;
	    Name: string;
	
	    static createFrom(source: any = {}) {
	        return new Table(source);
	    }
	
	    constructor(source: any = {}) {
	        if ('string' === typeof source) source = JSON.parse(source);
	        this.Id = source["Id"];
	        this.Name = source["Name"];
	    }
	}

}

