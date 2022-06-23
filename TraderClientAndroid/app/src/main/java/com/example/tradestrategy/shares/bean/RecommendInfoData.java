package com.example.tradestrategy.shares.bean;

public class RecommendInfoData {
    private String shares_name;
    private String shares_code;
    private String shares_time;
    private String mode;
    private String start_price;
    private String goal_price;
    private int ret_code;
    private boolean opt_result;

    public RecommendInfoData(String shares_name, String shares_code, String shares_time, String mode, String start_price, String goal_price, int ret_code, boolean opt_result) {
        this.shares_name = shares_name;
        this.shares_code = shares_code;
        this.shares_time = shares_time;
        this.mode = mode;
        this.start_price = start_price;
        this.goal_price = goal_price;
        this.ret_code = ret_code;
        this.opt_result = opt_result;
    }

    public String getShares_name() {
        return shares_name;
    }

    public void setShares_name(String shares_name) {
        this.shares_name = shares_name;
    }

    public String getShares_code() {
        return shares_code;
    }

    public void setShares_code(String shares_code) {
        this.shares_code = shares_code;
    }

    public String getShares_time() {
        return shares_time;
    }

    public void setShares_time(String shares_time) {
        this.shares_time = shares_time;
    }

    public String getMode() {
        return mode;
    }

    public void setMode(String mode) {
        this.mode = mode;
    }

    public String getStart_price() {
        return start_price;
    }

    public void setStart_price(String start_price) {
        this.start_price = start_price;
    }

    public String getGoal_price() {
        return goal_price;
    }

    public void setGoal_price(String goal_price) {
        this.goal_price = goal_price;
    }

    public int getRet_code() {
        return ret_code;
    }

    public void setRet_code(int ret_code) {
        this.ret_code = ret_code;
    }

    public boolean isOpt_result() {
        return opt_result;
    }

    public void setOpt_result(boolean opt_result) {
        this.opt_result = opt_result;
    }
}
