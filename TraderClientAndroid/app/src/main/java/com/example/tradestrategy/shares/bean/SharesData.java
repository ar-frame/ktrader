package com.example.tradestrategy.shares.bean;

public class SharesData {
    private int shares_id;//股票id
    private String shares_code;//股票代码
    private String shares_time;//股票时间
    private String shares_name;//股票名称
    private String accuracy;//推荐率
    private String new_price;//今日最新价格
    private String goal_price;//预测目标价格
    private String mode;//类型

    public SharesData(int shares_id, String shares_code, String shares_time, String shares_name, String accuracy, String new_price, String goal_price, String mode) {
        this.shares_id = shares_id;
        this.shares_code = shares_code;
        this.shares_time = shares_time;
        this.shares_name = shares_name;
        this.accuracy = accuracy;
        this.new_price = new_price;
        this.goal_price = goal_price;
        this.mode = mode;
    }

    public int getShares_id() {
        return shares_id;
    }

    public void setShares_id(int shares_id) {
        this.shares_id = shares_id;
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

    public String getShares_name() {
        return shares_name;
    }

    public void setShares_name(String shares_name) {
        this.shares_name = shares_name;
    }

    public String getAccuracy() {
        return accuracy;
    }

    public void setAccuracy(String accuracy) {
        this.accuracy = accuracy;
    }

    public String getNew_price() {
        return new_price;
    }

    public void setNew_price(String new_price) {
        this.new_price = new_price;
    }

    public String getGoal_price() {
        return goal_price;
    }

    public void setGoal_price(String goal_price) {
        this.goal_price = goal_price;
    }

    public String getMode() {
        return mode;
    }

    public void setMode(String mode) {
        this.mode = mode;
    }
}
