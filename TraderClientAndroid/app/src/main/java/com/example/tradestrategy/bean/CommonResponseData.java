package com.example.tradestrategy.bean;

public class CommonResponseData {
    private String ret_code;
    private String ret_msg;
    private String success;
    private String error_msg;

    public CommonResponseData(String ret_code, String ret_msg, String success, String error_msg) {
        this.ret_code = ret_code;
        this.ret_msg = ret_msg;
        this.success = success;
        this.error_msg = error_msg;
    }

    public CommonResponseData() {
    }

    public String getRet_code() {
        return ret_code;
    }

    public void setRet_code(String ret_code) {
        this.ret_code = ret_code;
    }

    public String getRet_msg() {
        return ret_msg;
    }

    public void setRet_msg(String ret_msg) {
        this.ret_msg = ret_msg;
    }

    public String getSuccess() {
        return success;
    }

    public void setSuccess(String success) {
        this.success = success;
    }

    public String getError_msg() {
        return error_msg;
    }

    public void setError_msg(String error_msg) {
        this.error_msg = error_msg;
    }
}
