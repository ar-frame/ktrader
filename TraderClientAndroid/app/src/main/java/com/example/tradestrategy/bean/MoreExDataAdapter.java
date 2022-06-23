package com.example.tradestrategy.bean;

import android.graphics.Color;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.tradestrategy.R;
import com.example.tradestrategy.strategy.StrategyData;

import java.util.ArrayList;
import java.util.List;

public class MoreExDataAdapter extends RecyclerView.Adapter<MoreExDataAdapter.ViewHolder>{
    private List<StrategyData> strategyDataList;
    private OnItemClickListener mItemClickListener;
    private OnItemLongClickListener mItemLongClickListener;

    static class ViewHolder extends RecyclerView.ViewHolder{
        TextView moreex_price,moreex_time,moreex_direction,moreex_level,moreex_type;

        public ViewHolder(View view){
            super(view);
            moreex_price=view.findViewById(R.id.moreex_price);
            moreex_time=view.findViewById(R.id.moreex_time);
            moreex_direction =view.findViewById(R.id.moreex_direction);
            moreex_level =view.findViewById(R.id.moreex_level);
            moreex_type = view.findViewById(R.id.moreex_type);
        }
    }

    public MoreExDataAdapter(List<StrategyData> list){
        strategyDataList=list;
    }

    @Override
    public MoreExDataAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.moreex_item,parent,false);
        RecyclerView.ViewHolder holder=new ViewHolder(view);
        return (ViewHolder) holder;
    }

    @Override
    public void onBindViewHolder(final MoreExDataAdapter.ViewHolder holder, final int position) {
        StrategyData strategyData=strategyDataList.get(position);

        holder.moreex_price.setText(strategyData.getPrice()+"");

        if(strategyData.getType().equals("sell"))
        {
            holder.moreex_direction.setText("卖出");
            holder.moreex_direction.setTextColor(Color.parseColor("#ff29c367"));
        }else {
            holder.moreex_direction.setText("买入");
            holder.moreex_direction.setTextColor(Color.RED);
        }

        holder.moreex_time.setText(strategyData.getTimedate());

        holder.moreex_level.setText(strategyData.getLevel()+"级");

        holder.moreex_type.setText(strategyData.getPair());


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
    public int getItemCount() {
        return strategyDataList.size();
    }

    //item的回调接口
    public interface OnItemClickListener {
        void onItemClick(View view, int Position);
    }

    //定义一个设置点击监听器的方法
    public void setOnItemClickListener(MoreExDataAdapter.OnItemClickListener itemClickListener) {
        this.mItemClickListener = itemClickListener;
    }

    public interface OnItemLongClickListener {
        void onItemLongClick(View view, int Position);
    }


    public void setOnItemLongClickListener(OnItemLongClickListener itemLongClickListener) {
        this.mItemLongClickListener = itemLongClickListener;
    }

    public void refresh(List<StrategyData> data){
        strategyDataList = new ArrayList<>(data);
        notifyDataSetChanged();
    }
}
