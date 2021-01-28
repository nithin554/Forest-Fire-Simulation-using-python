from time import sleep
import random
import mysql.connector
from datetime import datetime
class master_node:
    def __init__(self):
        self.values = []
        self.dt_string = ""
    def recieve_data(self,values,dt_string):
        self.values.append(values)
        self.dt_string = dt_string
    def update_data(self):
        values = self.values
        dt_string = self.dt_string
        print("----Master Node----")
        print("Updating node values into database.... ")
        for i in range(4):
            mycursor = mydb.cursor()
            sql = "INSERT INTO node_data VALUES (%s, %s, %s, %s, %s, %s)"
            val = (values[i][0],values[i][1],values[i][2],values[i][3],values[i][4],str(dt_string))
            mycursor.execute(sql, val)
            mydb.commit()
        self.values = []
master = master_node()
class node():
    def __init__(self):
        self.id = 0
        self.temp = 0
        self.humidity = 0
        self.loc_lat = 0
        self.loc_lon = 0
    def set_values(self,i,t,h,lat,lon):
        self.id = i
        self.temp = t
        self.humidity = h
        self.loc_lat = lat
        self.loc_lon = lon
    def get_values(self):
        return [self.id,self.temp,self.humidity,self.loc_lat,self.loc_lon]
    def send_data(self,values,dt_string):
        print("Sending Data to Master Node...")
        master.recieve_data(values,dt_string)
node1 = node()
node2 = node()
node3 = node()
node4 = node()
mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="12345"
)
mycursor = mydb.cursor()
sql = "use forest_fire;"
mycursor.execute(sql)
mydb.commit()
'''
sql = "INSERT INTO node_data VALUES (%s, %s, %s, %s, %s, %s)"
val = ("1","33","65","70","70","09:50")
mycursor.execute(sql, val)
mydb.commit()
'''
values = []
'''

'''
import pygame
pygame.init()
gameDisplay = pygame.display.set_mode((1000,600))
pygame.display.set_caption('Forest Fire Simulation')
clock = pygame.time.Clock()
crashed = False
width = 800
height = 600
black = (0,0,0)
white = (255,255,255)
color_light = (170,170,170)
color_dark = (100,100,100)
smallfont = pygame.font.SysFont('Corbel',35)
text = smallfont.render('Fire' , True , white)
pktImg = pygame.image.load('packet.png')
pktImg = pygame.transform.scale(pktImg, (20, 20))
sensorImg = pygame.image.load('sensor.png')
sensorImg = pygame.transform.scale(sensorImg, (30, 30))
monitor = pygame.image.load('monitor.png')
monitor = pygame.transform.scale(monitor, (30, 30))
data = pygame.image.load('database.png')
data = pygame.transform.scale(data, (40, 50))
x = 0
y = 0
reached = 0
ry = 0
fire = 0
q = 0
while not q:
    crashed = False
    x = 0
    y = 0
    reached = 0
    ry = 0
    status = "Sending to master node"
    while not crashed:
        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                crashed = True
                q = 1
            if event.type == pygame.MOUSEBUTTONDOWN:
                if width/2 <= mouse[0] <= width/2+140 and height/2 <= mouse[1] <= height/2+40:
                    if(fire==1):
                        text = smallfont.render('Fire' , True , white)
                        fire = 0
                    else:
                        text = smallfont.render('Normal' , True , white)
                        fire = 1
        try:
            gameDisplay.fill(white)
        except:
            break
        mouse = pygame.mouse.get_pos()
        if width/2 <= mouse[0] <= width/2+140 and height/2 <= mouse[1] <= height/2+40: 
            pygame.draw.rect(gameDisplay,color_light,[width/2,height/2,140,40])
              
        else: 
            pygame.draw.rect(gameDisplay,color_dark,[width/2,height/2,140,40])
        pygame.draw.rect(gameDisplay,color_dark,[400,50,500,40])
        gameDisplay.blit(smallfont.render('Status : ' + status , True , white) , (415,50))
        if(fire==0):
            mode = "Normal Day"
        else:
            mode = "Fire Alert"
        pygame.draw.rect(gameDisplay,color_dark,[400,100,500,40])
        gameDisplay.blit(smallfont.render('Mode : ' + mode , True , white) , (415,100))
        gameDisplay.blit(text , (width/2+15,height/2)) 
        gameDisplay.blit(monitor, (115,135))
        gameDisplay.blit(data, (285,125))
        gameDisplay.blit(pktImg, (60+x,70+x))
        gameDisplay.blit(pktImg, (200-x,70+x))
        gameDisplay.blit(pktImg, (40+x,210-x))
        gameDisplay.blit(pktImg, (200-x,220-x))
        gameDisplay.blit(pktImg, (150+y,140))
        pygame.draw.line(gameDisplay,black,(60,70),(120,140))
        pygame.draw.line(gameDisplay,black,(220,70),(140,140))
        pygame.draw.line(gameDisplay,black,(60,210),(120,160))
        pygame.draw.line(gameDisplay,black,(200,220),(140,160))
        pygame.draw.line(gameDisplay,black,(170,150),(280,150))
        gameDisplay.blit(sensorImg, (30,30))
        gameDisplay.blit(sensorImg, (220,30))
        gameDisplay.blit(sensorImg, (30,240))
        gameDisplay.blit(sensorImg, (220,250))
        pygame.display.update()
        clock.tick(10)
        if(x==50):
            reached = 1
            status = "Uploading to database"
            x=0
        if(reached==0):
            x += 5
        if(y==150):
            ry=1
            y=0
        if(reached==1 and ry == 1):
            y=0
            #sleep(3)
            crashed = True
        elif(reached==1):
            y += 10
        #sleep(3)
    
    if(fire==0):
        node1.set_values(1,random.randrange(25, 39),random.randrange(45, 80),70,70)
        node2.set_values(2,random.randrange(25, 39),random.randrange(45, 80),60,80)
        node3.set_values(3,random.randrange(25, 39),random.randrange(45, 80),50,90)
        node4.set_values(4,random.randrange(25, 39),random.randrange(45, 80),40,100)
    else:
        node1.set_values(1,random.randrange(41, 60),random.randrange(15, 44),70,70)
        node2.set_values(2,random.randrange(41, 60),random.randrange(15, 44),60,80)
        node3.set_values(3,random.randrange(41, 60),random.randrange(15, 44),50,90)
        node4.set_values(4,random.randrange(41, 60),random.randrange(15, 44),40,100)
    values = []
    values.append(node1.get_values())
    values.append(node2.get_values())
    values.append(node3.get_values())
    values.append(node4.get_values())
    print("Node1 values are : ")
    print(values[0])
    print("Node2 values are : ")
    print(values[1])
    print("Node3 values are : ")
    print(values[2])
    print("Node4 values are : ")
    print(values[3])
    now = datetime.now()
    dt_string = now.strftime("%Y/%m/%d %H:%M:%S")
    node1.send_data(values[0], dt_string)
    node2.send_data(values[1], dt_string)
    node3.send_data(values[2], dt_string)
    node4.send_data(values[3], dt_string)
    master.update_data()
    sleep(5)
pygame.quit()