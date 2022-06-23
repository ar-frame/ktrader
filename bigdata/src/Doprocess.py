# -*-coding:utf-8-*-
from time import ctime, sleep
import threading
import numpy as np
import collections
 
loops = ['广州', '北京']
t_list = ['01', '02', '03']
cldas_sum = collections.deque()
 
 
class MyThread(threading.Thread):
    def __init__(self, func, args, name=''):
        threading.Thread.__init__(self)
        self.name = name
        self.func = func
        self.args = args
        self.result = self.func(*self.args)
 
    def get_result(self):
        try:
            return self.result
        except Exception:
            return None
 
 
def loop(nloop):
    return nloop + "666"
 
 
def main():
    print('start at', ctime())
    threads = []
    nloops = range(len(loops))
    for i in nloops:
        t = MyThread(loop, (loops[i],), loop.__name__)
        threads.append(t)
    for i in nloops:   # start threads 此处并不会执行线程，而是将任务分发到每个线程，同步线程。等同步完成后再开始执行start方法
        threads[i].start()
    for i in nloops:   # jion()方法等待线程完成
        threads[i].join()
    print(threads[0].get_result())
    print('DONE AT:', ctime())
 
 
if __name__ == '__main__':
    main()