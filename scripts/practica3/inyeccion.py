import mysql.connector
from mysql.connector import Error

# Conexión a la base de datos
def create_connection():
    try:
        connection = mysql.connector.connect(
            host='localhost',        # Cambia por tu host
            user='usuario3',             # Cambia por tu usuario
            password='Contraseña3', # Cambia por tu contraseña
            database='secure_db'
        )
        if connection.is_connected():
            print("Conexión exitosa a la base de datos")
        return connection
    except Error as e:
        print(f"Error al conectar a la base de datos: {e}")
        return None

# Función vulnerable a inyección SQL
def vulnerable_sql_injection(connection, user_input):
    cursor = connection.cursor()

    # Consulta SQL vulnerable
    query = f"SELECT * FROM users WHERE email = '{user_input}';"
    print(f"Ejecutando consulta: {query}")
    
    try:
        cursor.execute(query)
        # Mostrar resultados
        rows = cursor.fetchall()
        for row in rows:
            print(row)
    except Error as e:
        print(f"Error ejecutando la consulta: {e}")
    finally:
        cursor.close()

# Ejecución del script
if _name_ == "_main_":
    connection = create_connection()
    
    if connection:
        # Ejemplo de inyección SQL
        # Un atacante podría introducir: ' OR '1'='1'; -- 
        user_input = input("Introduce el email del usuario: ")
        vulnerable_sql_injection(connection, user_input)
        
        connection.close()