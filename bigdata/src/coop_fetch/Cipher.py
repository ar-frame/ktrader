import binascii

class Cipher:

    @staticmethod
    def str2HexStr(str):
        return binascii.b2a_hex((u"%s" % str).encode("utf8")).decode()

    @staticmethod
    def hexStr2Str(str):
        return binascii.a2b_hex(str).decode("utf8")