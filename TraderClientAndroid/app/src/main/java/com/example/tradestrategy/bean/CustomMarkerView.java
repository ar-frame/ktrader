package com.example.tradestrategy.bean;

import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Color;
import android.util.Log;
import android.widget.TextView;

import com.example.tradestrategy.R;
import com.example.tradestrategy.strategy.StrategyData;

import com.github.mikephil.charting.components.MarkerView;
import com.github.mikephil.charting.data.CandleEntry;
import com.github.mikephil.charting.data.Entry;
import com.github.mikephil.charting.highlight.Highlight;
import com.github.mikephil.charting.utils.MPPointF;
import com.github.mikephil.charting.utils.Utils;

import java.util.List;

/**
 * 自定义图表的MarkerView(点击坐标点，弹出提示框)
 */

@SuppressLint("ViewConstructor")
public class CustomMarkerView extends MarkerView {
    private TextView tvContent, txt_level,txt_time,txt_code;
    private List<StrategyData> priceList;

    /**
     * @param context        上下文
     * @param layoutResource 资源文件
     * @param priceList      Y轴数值
     */
    public CustomMarkerView(Context context, int layoutResource, final List<StrategyData> priceList) {
        super(context, layoutResource);
        // 显示布局中的文本框
        tvContent = findViewById(R.id.txt_tips);
        txt_level = findViewById(R.id.txt_level);
        txt_time = findViewById(R.id.txt_time);
        txt_code = findViewById(R.id.txt_code);
        this.priceList = priceList;
    }


    @Override
    public void refreshContent(Entry e, Highlight highlight) {
        if (e instanceof CandleEntry) {

            CandleEntry ce = (CandleEntry) e;

            tvContent.setText("" + Utils.formatNumber(ce.getHigh(), 0, true));
            //Log.e("111111111111","我走的第一个");
        } else {
            //Log.e("111111111111","e is "+e);
            tvContent.setText(priceList.get((int) e.getX()).getPrice()+"");
            txt_level.setText(priceList.get((int) e.getX()).getLevel()+"级");
            txt_time.setText(priceList.get((int) e.getX()).getTimedate().substring(5));
            txt_code.setText(priceList.get((int) e.getX()).getCode()+"");
            if (priceList.get((int) e.getX()).getType().equals("sell")) {
                tvContent.setTextColor(Color.parseColor("#ff29c367"));
            } else {
                tvContent.setTextColor(android.graphics.Color.RED);
            }
        }

        super.refreshContent(e, highlight);
    }

    private MPPointF mOffset;

    @Override
    public MPPointF getOffset() {
        if (mOffset == null) {
            // center the marker horizontally and vertically
            mOffset = new MPPointF(-(getWidth() / 2), -getHeight());
        }

        return mOffset;
    }

}
