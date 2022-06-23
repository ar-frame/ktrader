package com.example.tradestrategy.strategy;

import android.annotation.SuppressLint;
import android.graphics.Color;
import android.net.Uri;
import android.support.annotation.NonNull;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;


import com.example.tradestrategy.MainActivity;
import com.example.tradestrategy.R;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.List;

public class StrategyDataAdapter extends RecyclerView.Adapter<StrategyDataAdapter.ViewHolder>{
    private List<StrategyData> strategyDataList;
    private OnItemClickListener mItemClickListener;
    private OnItemLongClickListener mItemLongClickListener;
    private DecimalFormat df= new DecimalFormat("#0.00");;

    static class ViewHolder extends RecyclerView.ViewHolder{
        TextView scheme_item_time,scheme_item_direction,scheme_item_profit,scheme_item_suc,scheme_item_price;
        ImageView scheme_item_flag;


        public ViewHolder(View view){
            super(view);
            scheme_item_time=view.findViewById(R.id.scheme_item_time);
            scheme_item_direction=view.findViewById(R.id.scheme_item_direction);
            scheme_item_profit =view.findViewById(R.id.scheme_item_profit);
            scheme_item_suc =view.findViewById(R.id.scheme_item_suc);
            scheme_item_price = view.findViewById(R.id.scheme_item_price);
            scheme_item_flag = view.findViewById(R.id.scheme_item_flag);
        }
    }
    public StrategyDataAdapter(List<StrategyData> list){
        strategyDataList = list;
    }

    //改变数据
    public void  changData(int position){
        strategyDataList.set(position,new StrategyData());
        notifyItemChanged(position);
    }


    @Override
    public StrategyDataAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.scheme_item,parent,false);
        RecyclerView.ViewHolder holder=new ViewHolder(view);
        return (ViewHolder) holder;
    }

    @Override
    public void onBindViewHolder(final StrategyDataAdapter.ViewHolder holder, final int position) {
        final StrategyData strategyData=strategyDataList.get(position);
            if(strategyData.getType().equals("sell"))
            {
                holder.scheme_item_direction.setText("卖出");
                holder.scheme_item_direction.setTextColor(Color.parseColor("#ff29c367"));
            }else {
                holder.scheme_item_direction.setText("买入");
                holder.scheme_item_direction.setTextColor(android.graphics.Color.RED);
            }
            int level=strategyData.getLevel();
            if(level>0){
                holder.scheme_item_suc.setText(strategyData.getLevel()+"级");
                if(strategyData.getType().equals("sell")){
                    holder.scheme_item_flag.setImageResource(R.mipmap.sell);
                }else {
                    holder.scheme_item_flag.setImageResource(R.mipmap.buy);
                }
            }else {
                holder.scheme_item_suc.setText(strategyData.getLevel()+"级");
            }


        holder.scheme_item_time.setText(strategyData.getTimedate());

       /* if(strategyData.getProfit().startsWith("-")){
            holder.scheme_item_profit.setText("¥"+strategyData.getProfit());
            holder.scheme_item_profit.setTextColor(android.graphics.Color.GREEN);
            //Log.e("111111111111","我是负数！"+strategyData.getProfit());
        }else {
            holder.scheme_item_profit.setText("¥"+strategyData.getProfit());
            //Log.e("111111111111","我不是负数！"+strategyData.getProfit());
        }*/

        holder.scheme_item_profit.setText(df.format(strategyData.getCurrency()));



        holder.scheme_item_price.setText(df.format(strategyData.getPrice()));


        //如果设置了回调，则设置点击事件
        if(mItemClickListener != null){
            holder.itemView.setOnClickListener(new View.OnClickListener() {

                @Override
                public void onClick(View v) {
                    mItemClickListener.onItemClick(holder.itemView, position);
                }
            });
        }

        if(mItemLongClickListener != null){
            holder.itemView.setOnLongClickListener(new View.OnLongClickListener() {
                @Override
                public boolean onLongClick(View view) {
                    mItemLongClickListener.onItemLongClick(holder.itemView,position);
                    return true;
                }
            });
        }

    }

    @Override
    public int getItemViewType(int position) {
        return position;
    }

    @Override
    public int getItemCount() {
        return strategyDataList.size();
    }

    //item的回调接口
    public interface OnItemClickListener {
        void onItemClick(View view, int Position);
    }

    //定义一个设置点击监听器的方法
    public void setOnItemClickListener(StrategyDataAdapter.OnItemClickListener itemClickListener) {
        this.mItemClickListener = itemClickListener;
    }

    public interface OnItemLongClickListener {
        void onItemLongClick(View view, int Position);
    }


    public void setOnItemLongClickListener(OnItemLongClickListener itemLongClickListener) {
        this.mItemLongClickListener = itemLongClickListener;
    }
}
