package com.example.tradestrategy.bean;

public class CheckCodeData {
    private String code;
    private String errmsg;


    public CheckCodeData(String code, String errmsg) {
        this.code = code;
        this.errmsg = errmsg;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    public String getErrmsg() {
        return errmsg;
    }

    public void setErrmsg(String errmsg) {
        this.errmsg = errmsg;
    }
}
