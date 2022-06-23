package com.example.tradestrategy.shares.adapter;

import android.content.Context;
import android.graphics.Typeface;
import android.support.annotation.NonNull;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.tradestrategy.R;
import com.example.tradestrategy.shares.bean.SharesRecommendData;

import java.util.List;

public class ShareRecommendAdapter extends RecyclerView.Adapter<ShareRecommendAdapter.ViewHolder> {

    private List<SharesRecommendData> recommendDataList;
    private OnItemClickListener mItemClickListener;
    private OnItemLongClickListener mItemLongClickListener;
    private Context context;

    static class ViewHolder extends RecyclerView.ViewHolder{
        private TextView start_time,end_time,mode,start_price,goal_price,end_price;
        private ImageView accurate;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            start_time=itemView.findViewById(R.id.start_time);
            end_time=itemView.findViewById(R.id.end_time);
            mode=itemView.findViewById(R.id.mode);
            start_price=itemView.findViewById(R.id.start_price);
            goal_price=itemView.findViewById(R.id.goal_price);
            end_price=itemView.findViewById(R.id.end_price);
            accurate=itemView.findViewById(R.id.tuijian_img);
        }
    }
    public ShareRecommendAdapter(List<SharesRecommendData> list , Context mContext){
        recommendDataList=list;
        context=mContext;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {
        View view= LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.rv_item_shares_history,viewGroup,false);
        RecyclerView.ViewHolder holder=new ViewHolder(view);
        return (ViewHolder) holder;
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder viewHolder, int position) {
        SharesRecommendData sharesRecommendData=recommendDataList.get(position);
        //设置字体样式
        Typeface typeface=Typeface.createFromAsset(context.getAssets(),"MixolydianTitlingRg-Regular.otf");
        if (sharesRecommendData.getAccurate()==true){
            viewHolder.accurate.setVisibility(View.VISIBLE);
        }else {
            viewHolder.accurate.setVisibility(View.GONE);
        }
        viewHolder.end_price.setTypeface(typeface);
        viewHolder.end_price.setText(sharesRecommendData.getEnd_price());
        viewHolder.goal_price.setTypeface(typeface);
        viewHolder.goal_price.setText(sharesRecommendData.getGoal_price());
        viewHolder.start_price.setTypeface(typeface);
        viewHolder.start_price.setText(sharesRecommendData.getStart_price());
        viewHolder.mode.setText(sharesRecommendData.getMode());
        viewHolder.start_time.setText(sharesRecommendData.getStart_time());
        viewHolder.end_time.setText("~"+sharesRecommendData.getEnd_time());

    }

    @Override
    public int getItemCount() {
        return recommendDataList.size();
    }

    //item的回调接口
    public interface OnItemClickListener {
        void onItemClick(View view, int Position);
    }

    //定义一个设置点击监听器的方法
    public void setOnItemClickListener(OnItemClickListener itemClickListener) {
        this.mItemClickListener = itemClickListener;
    }

    public interface OnItemLongClickListener {
        void onItemLongClick(View view, int Position);
    }


    public void setOnItemLongClickListener(OnItemLongClickListener itemLongClickListener) {
        this.mItemLongClickListener = itemLongClickListener;
    }
}
