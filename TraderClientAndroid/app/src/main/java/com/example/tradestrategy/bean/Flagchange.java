package com.example.tradestrategy.bean;

import android.app.Application;

public class Flagchange extends Application {
    private static int flagchange = 0;

    public static int getFlag() {
        return flagchange;
    }

    public static void setFlag(int flag) {
        flagchange = flag;
    }
}
