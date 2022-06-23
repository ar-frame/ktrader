package com.example.tradestrategy.bean;

import com.example.tradestrategy.strategy.StrategyData;
import com.github.mikephil.charting.data.BarDataSet;
import com.github.mikephil.charting.data.BarEntry;

import java.util.List;

public class MyBarDataSet extends BarDataSet {
    private List<StrategyData> dataList ;

    public MyBarDataSet(List<BarEntry> yVals, String label,List<StrategyData> dataList) {
        super(yVals, label);
        this.dataList = dataList;
    }

    @Override
    public int getColor(int index) {
        //根据getEntryForXIndex(index).getVal()获得Y值,然后去对比,判断
        //我这1000 4000是根据自己的需求写的,可以随便设,判断条件if根据自己需求
        int i = (int) getEntryForIndex(index).getX();
        if(dataList.get(i).getType().equals("buy"))
            return mColors.get(0);
        else // greater or equal than 100 red
            return mColors.get(1);
    }
}
