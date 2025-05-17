# Sistema de Gestión de Cuestionarios

## 🚀 Pasos para iniciar

1. Copia esta carpeta en `htdocs/` (por ejemplo: `C:/xampp/htdocs/cuestionarios`)
2. Crea la base de datos en MySQL con el nombre: `cuestionarios_db`
3. Ejecuta el script `create_admin.php` para generar el administrador por defecto:
   - **Usuario:** `admin`
   - **Contraseña:** `admin123`
4. Abre [http://localhost/cuestionarios](http://localhost/cuestionarios) en tu navegador

---

## 👤 Instrucciones para el Usuario (Participante)

### ✅ ¿Cómo ingresar a contestar un cuestionario?

1. En la pantalla principal, haz clic en **“Usuario”**.
2. Ingresa tu **número de documento** (no se requiere contraseña).
3. Verás una lista de cuestionarios disponibles que:
   - Aún no han vencido
   - Tienen preguntas asignadas

---

### 🧩 ¿Cómo se responde un cuestionario?

1. Haz clic en **“Comenzar”** junto al cuestionario que deseas responder.
2. El sistema mostrará **una pregunta por página**.
3. Marca tu respuesta y haz clic en **“Siguiente”**.
4. Si no respondes dentro de **2 minutos**, el sistema te desconectará automáticamente por inactividad.
5. Al volver a ingresar, **continuarás desde donde te quedaste**.
6. Al finalizar, verás un **resumen con tu puntaje** (respuestas correctas).

---

### 🚫 ¿Qué pasa si ya respondí un cuestionario?

- El sistema detecta automáticamente si ya completaste el cuestionario.
- En ese caso, se mostrará un mensaje indicando que **ya has finalizado** y no podrás repetirlo.

---
