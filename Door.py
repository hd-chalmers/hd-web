import time
import requests

# INIT
# hd_door = db_door.init_db()
# cursor = hd_door.cursor()
# Made by kjelle
# Slaughtered by sid
# Revised by penta

try:
    import RPi.GPIO as GPIO
except RuntimeError:
    print("Error importing RPi.GPIO")
inPin = 17
status = 0
oldStatus = 0
GPIO.setmode(GPIO.BCM)
GPIO.setup(inPin, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
status = GPIO.input(inPin)
print("Running door")

# def update_db(status):
#  global cursor
#  global hd_door
#  try:
#    db_door.update_val(cursor, status)
#  except Exception as e:
#    print(e)
#    print("Reconnecting to db.")
#    #reconnect to db
#    hd_door = db_door.init_db()
#    cursor = hd_door.cursor()
#    db_door.update_val(cursor, status)
#  hd_door.commit()
api_token = ""
url = "https://hd.chalmers.se/api/door"


def update_status(s):
    payload = {'api_token': api_token, 'status': s}
    r = requests.put(url, params=payload)
    if len(r.text) >= 1:
        return True


# READ INPUT
while True:
    if status != oldStatus:
        if status == 0:
            print("Door is now closed.")
        else:
            print("Door is now open!")
            # update_db(status)
        #db_door.update_status(status)
        update_status(status)

    if GPIO.input(inPin):
        oldStatus = status
        status = 1
    else:
        oldStatus = status
        status = 0
    time.sleep(1)
