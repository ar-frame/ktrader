package com.example.tradestrategy.bean;

public class SummaryData {
    private String maxStore;        //最大占有
    private String transferRate;    //转化率
    private String profit;          //总体盈利
    private int orderCount;         //总单
    private int orderBuyCount;      //多单
    private int orderSellCount;     //空单
    private double cprice;          //当前价格
    private String summary;         //持仓信息
    private int unit;               //单元价格

    public SummaryData(String maxStore, String transferRate, String profit, int orderCount, int orderBuyCount, int orderSellCount, double cprice, String summary, int unit) {
        this.maxStore = maxStore;
        this.transferRate = transferRate;
        this.profit = profit;
        this.orderCount = orderCount;
        this.orderBuyCount = orderBuyCount;
        this.orderSellCount = orderSellCount;
        this.cprice = cprice;
        this.summary = summary;
        this.unit = unit;
    }

    public String getMaxStore() {
        return maxStore;
    }

    public void setMaxStore(String maxStore) {
        this.maxStore = maxStore;
    }

    public String getTransferRate() {
        return transferRate;
    }

    public void setTransferRate(String transferRate) {
        this.transferRate = transferRate;
    }

    public String getProfit() {
        return profit;
    }

    public void setProfit(String profit) {
        this.profit = profit;
    }

    public int getOrderCount() {
        return orderCount;
    }

    public void setOrderCount(int orderCount) {
        this.orderCount = orderCount;
    }

    public int getOrderBuyCount() {
        return orderBuyCount;
    }

    public void setOrderBuyCount(int orderBuyCount) {
        this.orderBuyCount = orderBuyCount;
    }

    public int getOrderSellCount() {
        return orderSellCount;
    }

    public void setOrderSellCount(int orderSellCount) {
        this.orderSellCount = orderSellCount;
    }

    public double getCprice() {
        return cprice;
    }

    public void setCprice(double cprice) {
        this.cprice = cprice;
    }

    public String getSummary() {
        return summary;
    }

    public void setSummary(String summary) {
        this.summary = summary;
    }

    public int getUnit() {
        return unit;
    }

    public void setUnit(int unit) {
        this.unit = unit;
    }
}
