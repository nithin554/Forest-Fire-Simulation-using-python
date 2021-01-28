# Forest-Fire-Simulation-using-python
Simulating forest fire using python and a web application to display results

This project consists of a web application and a simple forest fire simulator made with python

Prerequisites:
1)Apache server for php (preferably XAMPP) - https://www.apachefriends.org/index.html
2)pygame library for python - pip install pygame
3)Any MySQL server (can use MySQL server in XAMPP or https://dev.mysql.com/downloads/workbench/ )

Start the application by running main.py and index.php

Simulator has the following functionalities:
1)Fire and Normal switch
2)Can update sensor data (4 sensors) for every 5 seconds to MySQL database

Web application has the following functionalities:
1)A chart to display the recent 8 records (temperature, humidity)
2)Google maps api to display geographic location of sensors
3)A data table which consists of full log for analysis
