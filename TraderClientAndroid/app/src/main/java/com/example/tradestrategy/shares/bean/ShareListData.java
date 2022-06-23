package com.example.tradestrategy.shares.bean;

import java.util.List;

public class ShareListData {
    private List<SharesData> data;
    private SharePageData page_obj;

    public ShareListData(List<SharesData> data, SharePageData page_obj) {
        this.data = data;
        this.page_obj = page_obj;
    }

    public List<SharesData> getData() {
        return data;
    }

    public void setData(List<SharesData> data) {
        this.data = data;
    }

    public SharePageData getPage_obj() {
        return page_obj;
    }

    public void setPage_obj(SharePageData page_obj) {
        this.page_obj = page_obj;
    }
}
