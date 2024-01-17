CREATE TABLE IF NOT EXISTS "Products" (
	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"user_id"	INTEGER NOT NULL,
	"category"	TEXT,
	"jancode"	TEXT NOT NULL,
	"pname"	TEXT,
	"brand"	TEXT,
	"store"	TEXT,
	"image"	TEXT,
	"site"	TEXT,
	"created"	TEXT,
	"modified"	TEXT,
	FOREIGN KEY("user_id") REFERENCES "Users"("id")
);


