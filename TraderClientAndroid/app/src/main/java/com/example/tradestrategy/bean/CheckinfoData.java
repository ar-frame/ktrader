package com.example.tradestrategy.bean;

public class CheckinfoData {
    private String err_msg;        //错误信息
    private boolean check_result;  //信息是否正确
    private int can_use_dayoff;    //剩余天数
    private String service_call;   //客服电话
    private String service_info;   //附加信息
    private String version_name;   //代言商
    private int isvip;          //VIP

    public CheckinfoData(String err_msg, boolean check_result, int can_use_dayoff, String service_call, String service_info, String version_name,int isvip) {
        this.err_msg = err_msg;
        this.check_result = check_result;
        this.can_use_dayoff = can_use_dayoff;
        this.service_call = service_call;
        this.service_info = service_info;
        this.version_name = version_name;
        this.isvip=isvip;
    }

    public String getErr_msg() {
        return err_msg;
    }

    public void setErr_msg(String err_msg) {
        this.err_msg = err_msg;
    }

    public boolean isCheck_result() {
        return check_result;
    }

    public void setCheck_result(boolean check_result) {
        this.check_result = check_result;
    }

    public int getCan_use_dayoff() {
        return can_use_dayoff;
    }

    public void setCan_use_dayoff(int can_use_dayoff) {
        this.can_use_dayoff = can_use_dayoff;
    }

    public String getService_call() {
        return service_call;
    }

    public void setService_call(String service_call) {
        this.service_call = service_call;
    }

    public String getService_info() {
        return service_info;
    }

    public void setService_info(String service_info) {
        this.service_info = service_info;
    }

    public String getVersion_name() {
        return version_name;
    }

    public void setVersion_name(String version_name) {
        this.version_name = version_name;
    }

    public int getIsvip(){

        return  isvip;
    }
    public void setIsvip(int isvip){
        this.isvip=isvip;

    }
}
