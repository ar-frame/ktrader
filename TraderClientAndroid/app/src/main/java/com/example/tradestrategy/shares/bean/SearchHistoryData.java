package com.example.tradestrategy.shares.bean;

import org.litepal.crud.LitePalSupport;

public class SearchHistoryData extends LitePalSupport {
    int id;
    String historytext;


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getHistorytext() {
        return historytext;
    }

    public void setHistorytext(String historytext) {
        this.historytext = historytext;
    }
}
