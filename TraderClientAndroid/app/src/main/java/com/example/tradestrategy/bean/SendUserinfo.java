package com.example.tradestrategy.bean;

public class SendUserinfo {
    private String code;             //标签
    private String register_code;    //激活码
    private String mac;              //MAC地址

    public SendUserinfo(String code, String register_code, String mac) {
        this.code = code;
        this.register_code = register_code;
        this.mac = mac;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    public String getRegister_code() {
        return register_code;
    }

    public void setRegister_code(String register_code) {
        this.register_code = register_code;
    }

    public String getMac() {
        return mac;
    }

    public void setMac(String mac) {
        this.mac = mac;
    }
}
