class Config:
    SERVER_ADDRESS=""
    AUTH_SERVER_OPKEY=""
    SERVER_RESPONSE_TAG=""
    USER_AUTH_KEY=""
    USER_ACCESS_TOKEN=""
    def __init__(self, SERVER_ADDRESS, AUTH_SERVER_OPKEY):
        self.SERVER_ADDRESS = SERVER_ADDRESS
        self.AUTH_SERVER_OPKEY = AUTH_SERVER_OPKEY
        self.SERVER_RESPONSE_TAG = "___SERVICE_STD_OUT_SEP___"

    def setUserAuthKey(self, ukey):
        self.USER_AUTH_KEY = ukey

    def setUserAccessToken(self, ukey):
        self.USER_ACCESS_TOKEN = ukey
