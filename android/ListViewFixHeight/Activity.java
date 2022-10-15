Usage:

//initializing the adapter
listView.setAdapter(adapter);
UIUtils.setListViewHeightBasedOnItems(listView);

//whenever the data changes
adapter.notifyDataSetChanged();
UIUtils.setListViewHeightBasedOnItems(listView);
