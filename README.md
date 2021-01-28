# Forest-Fire-Simulation-using-python
Simulating forest fire using python and a web application to display results

This project consists of a web application and a simple forest fire simulator made with python

Prerequisites:
1)Apache server for php (preferably XAMPP) - https://www.apachefriends.org/index.html<br />
2)pygame library for python - pip install pygame<br />
3)Any MySQL server (can use MySQL server in XAMPP or https://dev.mysql.com/downloads/workbench/ )<br />

Start the application by running main.py and index.php<br />

Simulator has the following functionalities:<br />
1)Fire and Normal switch<br />
2)Can update sensor data (4 sensors) for every 5 seconds to MySQL database<br />
<br />
Web application has the following functionalities:<br />
1)A chart to display the recent 8 records (temperature, humidity)<br />
2)Google maps api to display geographic location of sensors<br />
3)A data table which consists of full log for analysis<br />
