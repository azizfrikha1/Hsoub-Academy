import os
from dotenv import load_dotenv
import db_functions as db

load_dotenv()

PG_BASE_CONFIG = {
    "user": os.getenv("DB_USER"),
    "password": os.getenv("DB_PASSWORD"),
    "host": os.getenv("DB_HOST"),
    "port": int(os.getenv("DB_PORT", 5432))
}

DB_NAME = os.getenv("DB_NAME")

DB_CONFIG = PG_BASE_CONFIG.copy()
DB_CONFIG["dbname"] = DB_NAME

if __name__ == "__main__":
    db.create_database(DB_NAME, PG_BASE_CONFIG)
    db.create_tables(DB_CONFIG)

    mobile = "123456789"
    email = "test@test.com"

    db.add_or_update_customer(mobile, email, DB_CONFIG)

    retrieved_email = db.get_email(mobile, DB_CONFIG)
    print("email =", retrieved_email)

    missing_email = db.check_missing_email(mobile, DB_CONFIG)
    print("missing_email =", missing_email)