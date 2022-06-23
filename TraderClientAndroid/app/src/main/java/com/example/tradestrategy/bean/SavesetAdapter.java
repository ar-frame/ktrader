package com.example.tradestrategy.bean;

import android.annotation.SuppressLint;
import android.graphics.Color;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CompoundButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.example.tradestrategy.R;

import java.util.ArrayList;
import java.util.List;


public class SavesetAdapter extends RecyclerView.Adapter<SavesetAdapter.ViewHolder>{
    private List<Saveset> mSavesetList;
    private OnItemClickListener mItemClickListener;
    private OnItemLongClickListener mItemLongClickListener;


    //内部类ViewHolder：获得实例
    static class ViewHolder extends RecyclerView.ViewHolder {
        TextView loaditem_title,loaditem_notifylevel,loaditem_sun,loaditem_kong,loaditem_price;
        ImageView loaditem_img;
    /*    RelativeLayout load_item_up;
        LinearLayout load_item_down;*/

        public ViewHolder(View itemView) {
            super(itemView);
            loaditem_title = itemView.findViewById(R.id.loaditem_title );
            loaditem_notifylevel = itemView.findViewById(R.id.loaditem_notifylevel);
            loaditem_sun = itemView.findViewById(R.id.loaditem_sun);
            loaditem_kong =itemView.findViewById(R.id.loaditem_kong);
            loaditem_price = itemView.findViewById(R.id.loaditem_price);
            loaditem_img = itemView.findViewById(R.id.loaditem_img);

        }
    }

    //要展示的数据源传进来赋值给全局变量mAdduserList
    public SavesetAdapter(List<Saveset> savesetList) {
        //mSaveuserList = saveUserList;
        refresh(savesetList);
    }

    //先声明一个int成员变量
    private int thisPosition=-1;

    //再定义一个int类型的返回值方法
    public int getthisPosition() {
        return thisPosition;
    }

    //其次定义一个方法用来绑定当前参数值的方法
    //此方法是在调用此适配器的地方调用的，此适配器内不会被调用到
    public void setThisPosition(int thisPosition) {
        this.thisPosition = thisPosition;
    }


    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.load_item, parent, false);
        final ViewHolder holder = new ViewHolder(view);
        return holder;
    }

    @SuppressLint("ResourceType")
    @Override
    public void onBindViewHolder(final SavesetAdapter.ViewHolder holder, final int position) {
        Saveset saveset = mSavesetList.get(position);
        holder.loaditem_title.setText(saveset.getName());
        holder.loaditem_notifylevel.setText(saveset.getNotifylevel());
        holder.loaditem_sun.setText(saveset.getLoss());
        holder.loaditem_kong.setText(saveset.getControlamount());
        holder.loaditem_price.setText(saveset.getPrice());

        if(saveset.getFlag()==1){
            holder.loaditem_img.setVisibility(View.VISIBLE);
        }else {
            holder.loaditem_img.setVisibility(View.INVISIBLE);
        }

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

       /* if (position == getthisPosition()) {
           // Log.e("11111111","position is "+position);
           // Log.e("11111111","getthisPosition() is "+getthisPosition());
            holder.load_item_up.setBackgroundResource(R.color.colorNew);
            holder.load_item_down.setBackgroundResource(R.color.colorNew);
        }else {
            holder.load_item_up.setBackgroundResource(R.color.colorDefault);
            holder.load_item_down.setBackgroundResource(R.color.colorDefault);
        }*/
    }


    @Override
    public int getItemCount() {
        return mSavesetList.size();
    }

    //item的回调接口
    public interface OnItemClickListener {
        void onItemClick(View view, int Position);
    }

    //定义一个设置点击监听器的方法
    public void setOnItemClickListener(SavesetAdapter.OnItemClickListener itemClickListener) {
        this.mItemClickListener = itemClickListener;
    }

    public interface OnItemLongClickListener {
        void onItemLongClick(View view, int Position);
    }


    public void setOnItemLongClickListener(OnItemLongClickListener itemLongClickListener) {
        this.mItemLongClickListener = itemLongClickListener;
    }

    public void refresh(List<Saveset> data){
        mSavesetList = new ArrayList<>(data);
        notifyDataSetChanged();
    }
}
