#!/usr/bin/python
# -*- coding: utf-8 -*-
import Tkinter as tk

import cv2
from Tkinter import *
from PIL import Image, ImageTk
import os
import tkMessageBox
from multiprocessing import Process, Queue
import time
import random
import datetime
import MySQLdb
import tkFont
width, height = 800, 800
cap = cv2.VideoCapture(0)
flag,frame=cap.read()
date_string = time.strftime("%Y-%m-%d-%H:%M")
#cap.set(cv2.CAP_PROP_FRAME_WIDTH, width)
#cap.set(cv2.CAP_PROP_FRAME_HEIGHT, height)
global img_counter

root = tk.Tk()
customFont = tkFont.Font(family="Times new roman", size=12)
custom = tkFont.Font(family="Times new roman", size=10)
root.title('Тест засагч програм')
root.bind('<Escape>', lambda e: root.quit())
lmain = tk.Label(root)
lmain.pack(side ="left")

tk.Label(root, text='Оюутны мэдээлэл', bg='#aac2ff', font=customFont, width=20).pack(fill='x')


w1 = tk.Label(root, text="Оюутны шифр", font=custom)
w1.pack()

e = tk.Entry(root)
e.pack()

w2 = tk.Label(root, text="Хичээлийн код", font=custom)
w2.pack()

e1 = tk.Entry(root)
e1.pack()

w3 = tk.Label(root, text="Явцын сорил", font=custom)
w3.pack()

e2 = tk.Entry(root)
e2.pack()


####Database heseg####################
hicheel_code = ""
cipher = ""
soril = ""
#ugugdliin sangiin utguud
con = MySQLdb.connect('localhost', 'root', '', 'hicheel');
class Database:
    host = 'localhost'
    user = 'root'
    password = ''
    db = 'hicheel'

    def __init__(self):
        self.connection = MySQLdb.connect(self.host, self.user, self.password, self.db)
        self.cursor = self.connection.cursor()

    def insert(self, query):
        try:
            self.cursor.execute(query)
            self.connection.commit()
        except:
            self.connection.rollback()

    def query(self, query):
        cursor = self.connection.cursor( MySQLdb.cursors.DictCursor )
        cursor.execute(query)
        result = cursor.fetchall
        
        return cursor.fetchall()

    def __del__(self):
        self.connection.close()
#####################################

        
#entry = tk.Entry(root, width=10)
#entry.pack(side=tk.TOP,padx=10,pady=10)

#e = Entry(root,width=10)
#e.pack(side=TOP,padx=10,pady=10)

#entry.delete(0, tk.END)
#entry.insert(0, "Оюутны шифр")

def restart_program():
    e.delete(0, tk.END)
    e1.delete(0, tk.END)
    e2.delete(0, tk.END)
    label1.configure(text='')
def saveImage():
    ret, frame = cap.read()
  #  cv2.imshow("test", frame)
  #  img_name = "opencv_frame_{}.png".format(img_counter)
    filea = random.random()
    zurag_ner = str(filea) + '.jpg'
    
    cv2.imwrite(zurag_ner, frame)

    ##rotate
    image = cv2.imread(zurag_ner)
    (h, w) = image.shape[:2]
    center = (w / 2, h / 2)
    M = cv2.getRotationMatrix2D(center, 90, 1.0)
    rotated = cv2.warpAffine(image, M, (w, h))
    cv2.imwrite(zurag_ner, rotated)
    #cv2.waitKey(0)

    
    cipher = e.get()
    hicheel_code = e1.get()
    soril = e2.get()
    db = Database()
    query = "insert into students VALUES(null, '%s', '%s', '%s', '%s', '%s', '%d')" % \
 (str(cipher), str(hicheel_code), str(zurag_ner), "null", str(soril), 0)
    db.insert(query)
    print cipher
    print hicheel_code
    print soril
  #  tk.Label(root, text='Амжилттай дамжигдлаа').pack(side= tk.LEFT)
    label1.configure(text='Амжилттай илгээгдлээ')
   # cv2.imwrite(img_name, frame)

 
click_button = tk.Button(master=root, text='Илгээх', command=lambda: saveImage(), font=custom, width=10)

clear_label =  tk.Button(master=root, text='Шинэчлэх', command=lambda:  restart_program(), font=custom, width=10)

click_button.pack()
clear_label.pack()
label1 = Label(root, text="")
label1.pack()
#Button(root, text ="1", bg="#127391", width=10).pack()
#Button(root, text ="2", bg="#41caf4", width=15).pack()

#tk.Button(root, text='OK', command=onok).pack(side=tk.LEFT
def show_frame():
    _, frame = cap.read()
    frame = cv2.flip(frame, 1)
    cv2image = cv2.cvtColor(frame, cv2.COLOR_BGR2RGBA)
    img = Image.fromarray(cv2image)
    imgtk = ImageTk.PhotoImage(image=img)
    lmain.imgtk = imgtk
    lmain.configure(image=imgtk)
    lmain.after(10, show_frame)

show_frame()
root.mainloop()
