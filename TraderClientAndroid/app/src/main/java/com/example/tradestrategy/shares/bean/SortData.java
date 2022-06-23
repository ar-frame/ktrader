package com.example.tradestrategy.shares.bean;

public class SortData  {
    private  int sortnumber;
    private boolean sortRank;

    public SortData(int sortnumber) {
        this.sortnumber = sortnumber;
    }

    public int getSortnumber() {
        return sortnumber;
    }

    public void setSortnumber(int sortnumber) {
        this.sortnumber = sortnumber;
    }
}
