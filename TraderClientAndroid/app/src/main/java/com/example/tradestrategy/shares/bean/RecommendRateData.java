package com.example.tradestrategy.shares.bean;

public class RecommendRateData {
    private String accuracy;
    private String profit;
    private String history_number;
    private int ret_code;
    private Boolean opt_result;

    public RecommendRateData(String accuracy, String profit, String history_number, int ret_code, Boolean opt_result) {
        this.accuracy = accuracy;
        this.profit = profit;
        this.history_number = history_number;
        this.ret_code = ret_code;
        this.opt_result = opt_result;
    }

    public String getAccuracy() {
        return accuracy;
    }

    public void setAccuracy(String accuracy) {
        this.accuracy = accuracy;
    }

    public String getProfit() {
        return profit;
    }

    public void setProfit(String profit) {
        this.profit = profit;
    }

    public String getHistory_number() {
        return history_number;
    }

    public void setHistory_number(String history_number) {
        this.history_number = history_number;
    }

    public int getRet_code() {
        return ret_code;
    }

    public void setRet_code(int ret_code) {
        this.ret_code = ret_code;
    }

    public Boolean getOpt_result() {
        return opt_result;
    }

    public void setOpt_result(Boolean opt_result) {
        this.opt_result = opt_result;
    }
}
