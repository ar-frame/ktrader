package com.example.tradestrategy.bean;

import android.graphics.Color;
import android.util.Log;

import com.example.tradestrategy.R;
import com.example.tradestrategy.strategy.StrategyData;
import com.github.mikephil.charting.charts.CombinedChart;
import com.github.mikephil.charting.charts.LineChart;
import com.github.mikephil.charting.components.AxisBase;
import com.github.mikephil.charting.components.Legend;
import com.github.mikephil.charting.components.XAxis;
import com.github.mikephil.charting.components.YAxis;
import com.github.mikephil.charting.data.BarData;
import com.github.mikephil.charting.data.BarDataSet;
import com.github.mikephil.charting.data.BarEntry;
import com.github.mikephil.charting.data.CombinedData;
import com.github.mikephil.charting.data.Entry;
import com.github.mikephil.charting.data.LineData;
import com.github.mikephil.charting.data.LineDataSet;
import com.github.mikephil.charting.formatter.IAxisValueFormatter;
import java.util.ArrayList;
import java.util.List;

public class ChartUtil {
    public static void showChart(CombinedChart combineChart, final List<StrategyData> dataList,
                                 List<Float> lineValues, List<Float> barValues, String lineTitle, String barTitle) {
        combineChart.getDescription().setEnabled(false);//设置描述

        combineChart.setPinchZoom(false);//设置按比例放缩柱状图
        combineChart.setScaleEnabled(true);
        combineChart.setScaleYEnabled(false);
        combineChart.setScaleXEnabled(true);

        CustomMarkerView markerView = new CustomMarkerView(combineChart.getContext(), R.layout.chart_marker_view,dataList);
        combineChart.setMarker(markerView);

        //设置绘制顺序，让线在柱的上层
        combineChart.setDrawOrder(new CombinedChart.DrawOrder[]{
                CombinedChart.DrawOrder.BAR, CombinedChart.DrawOrder.LINE});

        final List<String> timelist = new ArrayList<>();
        for (int i =0 ;i<dataList.size();i++)
        {
            if(i==0){
                timelist.add(dataList.get(i).getTimedate().substring(5));
                //Log.e("第一个日期：",""+dataList.get(i).getTimedate().substring(5));
            }
            else if(i==dataList.size()-1) {
                timelist.add(dataList.get(i).getTimedate().substring(5));
               // Log.e("最后一个日期：",""+dataList.get(i).getTimedate().substring(5));
            }else {
                timelist.add("");
            }
            //timelist.add(dataList.get(i).getTimedate().substring(5));
        }

        //x坐标轴设置
        XAxis xAxis = combineChart.getXAxis();
        xAxis.setPosition(XAxis.XAxisPosition.BOTTOM);
        xAxis.setDrawGridLines(false);
        xAxis.setGranularity(1f);
       // xAxis.setLabelRotationAngle(-30);
        xAxis.setLabelCount(timelist.size() + 2);
        xAxis.setValueFormatter(new IAxisValueFormatter() {
            @Override
            public String getFormattedValue(float v, AxisBase axisBase) {
                if (v < 0 || v > (timelist.size() - 1))//使得两侧柱子完全显示
                    return "";
                return timelist.get((int) v);
            }
        });

        //y轴设置
        YAxis leftAxis = combineChart.getAxisLeft();
        leftAxis.setPosition(YAxis.YAxisLabelPosition.OUTSIDE_CHART);
        leftAxis.setDrawGridLines(false);
        /*leftAxis.setAxisMinimum(0f);*/

  /*      Float yMin = Double.valueOf(Collections.min(barValues) * 0.9).floatValue();
        Float yMax = Double.valueOf(Collections.max(barValues) * 1.1).floatValue();
        leftAxis.setAxisMaximum(yMax);
        leftAxis.setAxisMinimum(yMin);*/


        YAxis rightAxis = combineChart.getAxisRight();
        rightAxis.setPosition(YAxis.YAxisLabelPosition.OUTSIDE_CHART);
        rightAxis.setDrawGridLines(false);

        //图例设置
        Legend legend = combineChart.getLegend();
        legend.setHorizontalAlignment(Legend.LegendHorizontalAlignment.CENTER);
        legend.setVerticalAlignment(Legend.LegendVerticalAlignment.TOP);
        legend.setOrientation(Legend.LegendOrientation.HORIZONTAL);
        legend.setDrawInside(false);
        legend.setDirection(Legend.LegendDirection.LEFT_TO_RIGHT);
        legend.setForm(Legend.LegendForm.SQUARE);
        legend.setTextSize(12f);


        //设置组合图数据
        CombinedData data = new CombinedData();
        data.setData(setLineData(lineValues, lineTitle));
        data.setData(setBarData(barValues, barTitle,dataList));
        combineChart.setData(data);//设置组合图数据源
       // combineChart.setVisibleXRange(0,20);

        //使得两侧柱子完全显示
        xAxis.setAxisMinimum(combineChart.getCombinedData().getXMin() - 1f);
        xAxis.setAxisMaximum(combineChart.getCombinedData().getXMax() + 1f);

        //combineChart.setExtraTopOffset(10);
      //  combineChart.setExtraBottomOffset(10);
        combineChart.animateX(1500);//数据显示动画，从左往右依次显示
        combineChart.invalidate();
    }

    /**
     * 生成线图数据
     */
    private static LineData setLineData(List<Float> lineValues, String lineTitle) {
        ArrayList<Entry> lineEntries = new ArrayList<>();

        for (int i = 0, n = lineValues.size(); i < n; ++i) {
            lineEntries.add(new Entry(i, lineValues.get(i)));
        }

        LineDataSet lineDataSet = new LineDataSet(lineEntries, lineTitle);
        lineDataSet.setColor(Color.rgb(0, 90, 255));
        lineDataSet.setLineWidth(1.5f);//设置线的宽度
        lineDataSet.setCircleColor(Color.rgb(0, 90, 255));//设置圆圈的颜色
        lineDataSet.setCircleColorHole(Color.rgb(231, 239, 200));//设置圆圈内部洞的颜色
        //lineDataSet.setValueTextColor(Color.rgb(254,116,139));
        lineDataSet.setAxisDependency(YAxis.AxisDependency.LEFT);//设置线数据依赖于左侧y轴
        lineDataSet.setDrawValues(false);//不绘制线的数据


        LineData lineData = new LineData(lineDataSet);
        lineData.setValueTextSize(10f);
  /*      lineData.setValueFormatter(new IValueFormatter() {
            @Override
            public String getFormattedValue(float value, Entry entry, int i, ViewPortHandler viewPortHandler) {
                return StringUtils.double2String(value, 2);
            }
        });*/

        return lineData;
    }

    /**
     * 生成柱图数据
     *
     * @param barValues
     * @return
     */
    private static BarData setBarData(List<Float> barValues, String barTitle,List<StrategyData> dataList) {
        ArrayList<BarEntry> barEntries = new ArrayList<>();

        for (int i = 0, n = barValues.size(); i < n; ++i) {
            barEntries.add(new BarEntry(i, barValues.get(i)));
        }

       /* BarDataSet barDataSet = new BarDataSet(barEntries, barTitle);
        //barDataSet.setColors(new int[]{Color.RED,Color.GREEN});
        barDataSet.setColor(Color.rgb(231, 239, 255));
        barDataSet.setValueTextColor(Color.rgb(159, 143, 186));
        barDataSet.setAxisDependency(YAxis.AxisDependency.RIGHT);*/

        MyBarDataSet dataSet = new MyBarDataSet(barEntries, barTitle,dataList);
        dataSet.setColors(new int[]{Color.parseColor("#FFF97373"),Color.parseColor("#FF64D391")});
        dataSet.setValueTextColor(Color.rgb(159, 143, 186));
        dataSet.setAxisDependency(YAxis.AxisDependency.RIGHT);

        BarData barData = new BarData(dataSet);
        barData.setValueTextSize(10f);
        barData.setBarWidth(0.9f);
     /*   barData.setValueFormatter(new IValueFormatter() {
            @Override
            public String getFormattedValue(float value, Entry entry, int i, ViewPortHandler viewPortHandler) {
                return StringUtils.double2String(value, 2);
            }
        });*/

        return barData;
    }

}



