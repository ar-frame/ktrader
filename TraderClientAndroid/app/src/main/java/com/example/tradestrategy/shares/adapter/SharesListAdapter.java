package com.example.tradestrategy.shares.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.support.annotation.NonNull;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.CollapsibleActionView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.example.tradestrategy.R;
import com.example.tradestrategy.shares.activity.SharesDetailActivity;
import com.example.tradestrategy.shares.bean.SharesData;

import org.greenrobot.eventbus.EventBus;

import java.util.List;

public class SharesListAdapter extends RecyclerView.Adapter<SharesListAdapter.ViewHolder> {
    private List<SharesData> sharesDataList;
    private OnItemClickListener mItemClickListener;
    private OnItemLongClickListener mItemLongClickListener;
    public Context context;

         static class  ViewHolder extends RecyclerView.ViewHolder {
            private TextView shares_id,shares_name,shares_code,shares_time,new_price,goal_price,mode,accuracy;
            private LinearLayout item_shares;

            public ViewHolder(View view){
                super(view);

                shares_code=view.findViewById(R.id.shares_code);
                shares_name=view.findViewById(R.id.shares_name);
                shares_time=view.findViewById(R.id.shares_time);
                new_price=view.findViewById(R.id.new_price);
                goal_price=view.findViewById(R.id.goal_price);
                mode=view.findViewById(R.id.mode);
                accuracy=view.findViewById(R.id.accuracy);
                item_shares=view.findViewById(R.id.item_shares);

             }

        }
        public SharesListAdapter(List<SharesData> list,Context mContext){
          context=mContext;
          sharesDataList=list;


    }
    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {
        View view= LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.rv_item_shares,viewGroup,false);
        RecyclerView.ViewHolder holder =new ViewHolder(view);

        return (ViewHolder) holder;
    }

    @Override
    public void onBindViewHolder(@NonNull final ViewHolder viewHolder, final int position) {
            final SharesData sharesData=sharesDataList.get(position);
            //设置字体样式
            Typeface typeface=Typeface.createFromAsset(context.getAssets(),"MixolydianTitlingRg-Regular.otf");
            viewHolder.shares_name.setText(sharesData.getShares_name());
            viewHolder.shares_code.setText(sharesData.getShares_code());
            viewHolder.shares_time.setText(sharesData.getShares_time());
            viewHolder.mode.setText(sharesData.getMode());
            viewHolder.new_price.setTypeface(typeface);
            viewHolder.new_price.setText(sharesData.getNew_price());
            viewHolder.goal_price.setTypeface(typeface);
            viewHolder.goal_price.setText(sharesData.getGoal_price());
            viewHolder.accuracy.setText(sharesData.getAccuracy());
        //如果设置了回调，则设置点击事件
        if (mItemClickListener!=null){

            viewHolder.itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    EventBus.getDefault().postSticky(new SharesData(sharesData.getShares_id(),sharesData.getShares_code(),sharesData.getShares_time(),
                            sharesData.getShares_name(),sharesData.getAccuracy(),sharesData.getNew_price(),sharesData.getGoal_price(),sharesData.getMode()));
                    mItemClickListener.onItemClick(viewHolder.itemView, position);
                }
            });

        }

        if (mItemLongClickListener != null) {
            viewHolder.itemView.setOnLongClickListener(new View.OnLongClickListener() {
                @Override
                public boolean onLongClick(View view) {
                    mItemLongClickListener.onItemLongClick(viewHolder.itemView, position);
                    return true;
                }
            });
        }
    }

    @Override
    public int getItemCount() {
        return sharesDataList.size();
    }

    //item的回调接口
    public interface OnItemClickListener {
        void onItemClick(View view, int Position);
    }

    //定义一个设置点击监听器的方法
    public void setOnItemClickListener(SharesListAdapter.OnItemClickListener itemClickListener) {
        this.mItemClickListener = itemClickListener;
    }

    public interface OnItemLongClickListener {
        void onItemLongClick(View view, int Position);
    }


    public void setOnItemLongClickListener(OnItemLongClickListener itemLongClickListener) {
        this.mItemLongClickListener = itemLongClickListener;
    }

}
