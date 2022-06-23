#!/usr/bin/env python3.6
# -*- coding: utf-8 -*-

'test for dev moudule'
__author__ = 'assnr'

import sys

def test():
    args = sys.argv
    if len(args) == 1:
        print("hello world")
    elif len(args) == 2:
        print("hello world %s" % args[1])
    else:
        print("too many args")

if __name__ == "__main__":
    test()
