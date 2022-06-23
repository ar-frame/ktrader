package com.example.tradestrategy.bean;

import android.content.Context;
import android.support.annotation.Nullable;
import android.support.v7.widget.RecyclerView;
import android.util.AttributeSet;
import android.util.Log;
import android.view.MotionEvent;
import android.view.ViewConfiguration;

/**
 * @author zxl on 2018/7/19.
 *         discription: 抗滑动冲突Rv 加入了滑动最小数值辨别
 */

public class TNoConflictRecyclerView extends RecyclerView {
    private static final String TAG = "NoConflictRecyclerView";
    private float mStartX;
    private float mStartY;
    private int  mTouchSlop;


    public TNoConflictRecyclerView(Context context) {
        this(context,null);
    }

    public TNoConflictRecyclerView(Context context, @Nullable AttributeSet attrs) {
        this(context, attrs,0);
    }

    public TNoConflictRecyclerView(Context context, @Nullable AttributeSet attrs, int defStyle) {
        super(context, attrs, defStyle);
        mTouchSlop = ViewConfiguration.get(context).getScaledTouchSlop();
        Log.e(TAG,"最小滑动距离  mTouchSlop = "+mTouchSlop);
    }

    @Override
    public boolean dispatchTouchEvent(MotionEvent ev) {
        switch (ev.getAction())
        {
            case MotionEvent.ACTION_DOWN:
                mStartX = ev.getRawX();
                mStartY = ev.getRawY();
                break;
            case MotionEvent.ACTION_MOVE:
                float endY = ev.getRawY();
                float endX = ev.getRawX();
                float x = endX - mStartX;
                float y = endY - mStartY;
                /* 左右滑动不拦截,上下滑动拦截*/
                if (Math.abs(y) > Math.abs(x))
                {
                    Log.e(TAG,"dispatchTouchEvent  y = "+y);
                    /* 已经在顶部了*/
                    if (y > mTouchSlop && !canScrollVertically(-1)){
                        getParent().requestDisallowInterceptTouchEvent(false);
                    }else if (y < -1 * mTouchSlop && !canScrollVertically(1)){
                        // 已经在底部了 不能再上滑了 ========================
                        getParent().requestDisallowInterceptTouchEvent(false);
                    }else {
                        getParent().requestDisallowInterceptTouchEvent(true);
                    }
                }else {
                    getParent().requestDisallowInterceptTouchEvent(false);
                }
                break;
            default:
                break;

        }
        return super.dispatchTouchEvent(ev);
    }


    @Override
    public void onScrolled(int dx, int dy) {
        super.onScrolled(dx, dy);
        Log.e("Rv正在滑动","-dx ="+dx+"---dy ="+dy);
    }

    @Override
    protected void onScrollChanged(int l, int t, int oldl, int oldt) {
        super.onScrollChanged(l, t, oldl, oldt);
    }
}
