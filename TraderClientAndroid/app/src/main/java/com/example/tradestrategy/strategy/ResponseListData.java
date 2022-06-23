package com.example.tradestrategy.strategy;

import com.example.tradestrategy.strategy.StrategyData;

import java.util.List;

public class ResponseListData<E> {
    private String code;
    private List<E> data;

    public ResponseListData(String code, List<E> data) {
        this.code = code;
        this.data = data;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    public List<E> getData() {
        return data;
    }

    public void setData(List<E> data) {
        this.data = data;
    }
}
