package com.example.tradestrategy.shares.bean;

import java.util.List;

public class ShareRecommendListData  {
    private List<SharesRecommendData> data;
    private SharePageData page_obj;

    public ShareRecommendListData(List<SharesRecommendData> data, SharePageData page_obj) {
        this.data = data;
        this.page_obj = page_obj;
    }

    public List<SharesRecommendData> getData() {
        return data;
    }

    public void setData(List<SharesRecommendData> data) {
        this.data = data;
    }

    public SharePageData getPage_obj() {
        return page_obj;
    }

    public void setPage_obj(SharePageData page_obj) {
        this.page_obj = page_obj;
    }
}
