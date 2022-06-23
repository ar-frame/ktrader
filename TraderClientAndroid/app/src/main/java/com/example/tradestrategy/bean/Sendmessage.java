package com.example.tradestrategy.bean;

public class Sendmessage {
    private String code;
    private double currency;

    public Sendmessage(String code, double currency) {
        this.code = code;
        this.currency = currency;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    public double getCurrency() {
        return currency;
    }

    public void setCurrency(double currency) {
        this.currency = currency;
    }
}
