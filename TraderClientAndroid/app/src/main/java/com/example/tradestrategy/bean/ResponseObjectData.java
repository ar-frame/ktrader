package com.example.tradestrategy.bean;

import java.util.List;

public class ResponseObjectData<T> {
    private String code;
    private T data;

    public ResponseObjectData(String code, T data) {
        this.code = code;
        this.data = data;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    public T getData() {
        return data;
    }

    public void setData(T data) {
        this.data = data;
    }
}
