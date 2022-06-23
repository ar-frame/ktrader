package com.example.tradestrategy.shares.bean;

public class SharePageData {
   private  int total_page;
   private int total_record;
   private int current_page;

    public SharePageData(int total_page, int total_record, int current_page) {

        this.total_page = total_page;
        this.total_record = total_record;
        this.current_page = current_page;
    }

    public int getTotal_page() {
        return total_page;
    }

    public void setTotal_page(int total_page) {
        this.total_page = total_page;
    }

    public int getTotal_record() {
        return total_record;
    }

    public void setTotal_record(int total_record) {
        this.total_record = total_record;
    }

    public int getCurrent_page() {
        return current_page;
    }

    public void setCurrent_page(int current_page) {
        this.current_page = current_page;
    }
}
