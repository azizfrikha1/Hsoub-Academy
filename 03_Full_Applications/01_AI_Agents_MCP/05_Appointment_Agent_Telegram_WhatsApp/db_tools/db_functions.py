import psycopg2
from psycopg2.extensions import ISOLATION_LEVEL_AUTOCOMMIT 


def create_database(DB_NAME, PG_BASE_CONFIG):
    try:
        conn = psycopg2.connect(**PG_BASE_CONFIG, dbname="postgres")
        conn.set_isolation_level(ISOLATION_LEVEL_AUTOCOMMIT) 
        
        with conn.cursor() as cur:
            cur.execute("SELECT 1 FROM pg_database WHERE datname = %s", (DB_NAME,))
            if not cur.fetchone():
                cur.execute(f'CREATE DATABASE "{DB_NAME}"')
                print(f"تم إنشاء قاعدة البيانات: {DB_NAME}")
            else:
                print(f"ℹ️ قاعدة البيانات موجودة مسبقًا: {DB_NAME}")
        conn.close()
    
    except Exception as e:
        print(f"فشل في إنشاء قاعدة البيانات: {e}")


def create_tables(DB_CONFIG):
    try:
        with psycopg2.connect(**DB_CONFIG) as conn:
            with conn.cursor() as cur:
                cur.execute("""
                    CREATE TABLE IF NOT EXISTS customers (
                        mobile TEXT PRIMARY KEY,
                        email TEXT,
                        created_at TIMESTAMP DEFAULT NOW()
                    );
                """)

                cur.execute("""
                    CREATE TABLE IF NOT EXISTS conversations (
                        id SERIAL PRIMARY KEY,
                        mobile TEXT,
                        role TEXT,
                        content TEXT,
                        timestamp TIMESTAMP DEFAULT NOW()
                    );
                """)
            conn.commit()
        print("تم إنشاء الجداول بنجاح.")
    
    except Exception as e:
        print(f"فشل في إنشاء الجداول: {e}")


def add_or_update_customer(mobile, email="", DB_CONFIG=None):
    try:
        with psycopg2.connect(**DB_CONFIG) as conn:
            with conn.cursor() as cur:
                # Optimized using PostgreSQL UPSERT syntax
                cur.execute("""
                    INSERT INTO customers (mobile, email) 
                    VALUES (%s, %s)
                    ON CONFLICT (mobile) 
                    DO UPDATE SET email = EXCLUDED.email
                    WHERE EXCLUDED.email IS NOT NULL AND EXCLUDED.email != '';
                """, (mobile, email))
            conn.commit()  # Added commit to apply changes
    except Exception as e:
        print(f"فشل في إدراج/تحديث عميل: {e}")


def log_conversation(mobile: str, role: str, content: str, DB_CONFIG):
    try:
        with psycopg2.connect(**DB_CONFIG) as conn:
            with conn.cursor() as cur:
                cur.execute("""
                    INSERT INTO conversations (mobile, role, content)
                    VALUES (%s, %s, %s)
                """, (mobile, role, content))
            conn.commit()  # Added commit to apply changes
    except Exception as e:
        print(f"فشل في إدراج محادثة عميل: {e}")


def get_email(mobile: str, DB_CONFIG):
    try:
        with psycopg2.connect(**DB_CONFIG) as conn:
            with conn.cursor() as cur:
                cur.execute("SELECT email FROM customers WHERE mobile = %s", (mobile,))
                row = cur.fetchone()
                return row[0] if row and row[0] else None
    except Exception as e:
        print(f"فشل في استعادة بريد عميل: {e}")
        return None


def check_missing_email(mobile: str, DB_CONFIG):
    try:
        with psycopg2.connect(**DB_CONFIG) as conn:
            with conn.cursor() as cur:
                cur.execute("SELECT email FROM customers WHERE mobile = %s", (mobile,))
                result = cur.fetchone()
                return result is None or not result[0] or result[0].strip() == ""
    except Exception as e:
        print(f"فشل في التحقق من وجود بريد عميل: {e}")
        return True