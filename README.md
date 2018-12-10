## Guardar y extraer información de hojas de cálculo con [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io/en/develop/)

Pequeña practica para almacenar información en hojas de cálculo. Debido a que muchas veces se necesita de una solución para almacenar informácion y sin tener que ser tan compleja para usuarios finales en la parte de implementación.

Esta idea surge para tener algo más sencillo que ejecutar cuando el usuario no tenga asistencia presencial y de forma remota se puede complicar a la hora de dar instrucciones, lo que ocasiona perdida de tiempo y hasta daños a archivos importantes para el funcionamiento del proyecto.

Un ejemplo claro y de muchos problemas es dar instrucciones para la configuración de la base de datos, y hay ocasiones que no es necesario tener algo de ese tipo para almacenar información, es realizar mucho pasos para algo no tan complejo.

### Una pequeña ventaja

En las hojas de cálculo existen las fórmulas que puede ser ventajosas cuando se quieren hacer cálculos rápidos, por ejemplo alguna suma, cosa que con programación lleva una cantidad de pasos tediosos para algo tan pequeño, en cambio con las hojas de cálculo, actualizas un celda, se realizan los procesos con las fórmulas ya establecidos en el documento, y luego solo extraer el resultado de otra celda, el documento lo hace todo por ti.

### Utiliza .xls

Recomendablemente utiliza los archivos con extensión _.xls_ debido que los editores como _Libre Office_ tiene un buen soporte de ellos, y no procuro no utilizar _.xlsx_ ya que la libreria no tiene soporte para las fórmulas de esa extensión, debido que se sobreescriben y agregan prefijos que la libreria aún no agrega para la conversión, y te puede resultar en dolores de cabeza si no lees bien la documentación y encontrar específicamente la línea que necesitas leer.
***
Archivos solamente de ejemplo, ya que simulan el flujo de tener una interfaz gráfica, y esa información se sobreescribe en la hoja de cálculo, que posteriormente realiza el resultado de las fórmulas que depende del dato recién ingresado, luego obtener el valor de la celda resultado para pasarlo a otra hoja que igualmente tiene fórmulas, y así sucesivamente hasta actualizar las celdas que son necesarias para obtener un resultado. Si quieres observar la interfaz gráfica solo revisa la carpeta _"/capturas"_
