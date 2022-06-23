class ServerResponseException(Exception):
    def __init__(self, errstr):
        self.errstr = errstr
    def __str__(self):
        return "ServerResponseException: " + self.errstr
	
	
