package com.example.tradestrategy.strategy;

import android.os.Parcel;
import android.os.Parcelable;

public class StrategyData implements Parcelable {
    private String type;         //方向：sell或buy
    private String pair;         //品种
    private double price;        //价格
    private String timedate;     //时间
    private String profit;       //盈利
    private double currency;     //单元价格（金额）
    private int level;           //级别
    private int code;            //能级
    public static final Creator<StrategyData> CREATOR = new Creator<StrategyData>() {
        @Override
        public StrategyData createFromParcel(Parcel in) {
            StrategyData strategyData = new StrategyData();
            strategyData.type = in.readString();
            strategyData.pair = in.readString();
            strategyData.price = in.readDouble();
            strategyData.timedate = in.readString();
            strategyData.profit = in.readString();
            strategyData.currency = in.readDouble();
            strategyData.level = in.readInt();
            strategyData.code = in.readInt();
            return  strategyData;
        }
        @Override
        public StrategyData[] newArray(int size) {
            return new StrategyData[size];
        }
    };

    public double getPrice() {
        return price;
    }

    public void setPrice(double price) {
        this.price = price;
    }

    public int getCode() {
        return code;
    }

    public void setCode(int code) {
        this.code = code;
    }

    public int getLevel() {
        return level;
    }

    public void setLevel(int level) {
        this.level = level;
    }

    public double getCurrency() {
        return currency;
    }

    public void setCurrency(double currency) {
        this.currency = currency;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getPair() {
        return pair;
    }

    public void setPair(String pair) {
        this.pair = pair;
    }



    public String getTimedate() {
        return timedate;
    }

    public void setTimedate(String timedate) {
        this.timedate = timedate;
    }

    public String getProfit() {
        return profit;
    }

    public void setProfit(String profit) {
        this.profit = profit;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel parcel, int flags) {
        parcel.writeString(type);
        parcel.writeString(pair);
        parcel.writeDouble(price);
        parcel.writeString(timedate);
        parcel.writeString(profit);
        parcel.writeDouble(currency);
        parcel.writeInt(level);
        parcel.writeInt(code);
    }
}
