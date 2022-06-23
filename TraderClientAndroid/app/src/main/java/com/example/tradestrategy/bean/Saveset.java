package com.example.tradestrategy.bean;

import android.os.Parcel;
import android.os.Parcelable;

public class Saveset implements Parcelable {
    private int id;
    private String name;            //名称
    private String notifylevel;     //通知等级
    private String loss;            //止损
    private String controlamount;   //仓位控量
    private String price;           //单元价格
    private int flag;               //是否选中

    public Saveset() {
    }

    public Saveset(int id, String name, String notifylevel, String loss, String controlamount, String price, int flag) {
        this.id = id;
        this.name = name;
        this.notifylevel = notifylevel;
        this.loss = loss;
        this.controlamount = controlamount;
        this.price = price;
        this.flag = flag;
    }

    private Saveset(Parcel in) {
        id = in.readInt();
        name = in.readString();
        notifylevel = in.readString();
        loss = in.readString();
        controlamount = in.readString();
        price = in.readString();
        flag = in.readInt();
    }

    public static final Creator<Saveset> CREATOR = new Creator<Saveset>() {
        @Override
        public Saveset createFromParcel(Parcel in) {
            return new Saveset(in);
        }

        @Override
        public Saveset[] newArray(int size) {
            return new Saveset[size];
        }
    };

    public String getNotifylevel() {
        return notifylevel;
    }

    public void setNotifylevel(String notifylevel) {
        this.notifylevel = notifylevel;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getFlag() {
        return flag;
    }

    public void setFlag(int flag) {
        this.flag = flag;
    }

    public String getPrice() {
        return price;
    }

    public void setPrice(String price) {
        this.price = price;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getLoss() {
        return loss;
    }

    public void setLoss(String loss) {
        this.loss = loss;
    }

    public String getControlamount() {
        return controlamount;
    }

    public void setControlamount(String controlamount) {
        this.controlamount = controlamount;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel parcel, int flags) {
        parcel.writeInt(id);
        parcel.writeString(name);
        parcel.writeString(notifylevel);
        parcel.writeString(loss);
        parcel.writeString(controlamount);
        parcel.writeString(price);
        parcel.writeInt(flag);
    }
}
