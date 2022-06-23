package com.example.tradestrategy.shares.bean;

public class SharesRecommendData {
    private String start_time;
    private String end_time;
    private String mode;
    private String start_price;
    private String goal_price;
    private String end_price;
    private  Boolean accurate;

    public SharesRecommendData(String start_time, String end_time, String mode, String start_price, String goal_price, String end_price,Boolean accurate) {
        this.start_time = start_time;
        this.end_time = end_time;
        this.mode = mode;
        this.start_price = start_price;
        this.goal_price = goal_price;
        this.end_price = end_price;
        this.accurate = accurate;
    }

    public String getStart_time() {
        return start_time;
    }

    public void setStart_time(String start_time) {
        this.start_time = start_time;
    }

    public String getEnd_time() {
        return end_time;
    }

    public void setEnd_time(String end_time) {
        this.end_time = end_time;
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

    public String getEnd_price() {
        return end_price;
    }

    public void setEnd_price(String end_price) {
        this.end_price = end_price;
    }

    public Boolean getAccurate() {
        return accurate;
    }

    public void setAccurate(Boolean accurate) {
        this.accurate = accurate;
    }
}
