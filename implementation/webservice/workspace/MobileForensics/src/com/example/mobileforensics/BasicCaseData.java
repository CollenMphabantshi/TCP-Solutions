package com.example.mobileforensics;

import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;

public class BasicCaseData extends Activity {

	private String username;
	private TextView vicName;
	private TextView vicID;
	private TextView ioName;
	private TextView ioCellNo;
	private TextView foosName;
	private TextView sceneTime;
	private TextView sceneLocation;
	private TextView sceneTemperature;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_basic_case_data);
		
		try{
			username = getIntent().getExtras().getString("USERNAME");
			
			vicName = (TextView) findViewById(R.id.bci_VicName);
			vicID = (TextView) findViewById(R.id.bci_vicID);
			ioName = (TextView) findViewById(R.id.bci_io);
			foosName = (TextView) findViewById(R.id.bci_foos);
			sceneTime = (TextView) findViewById(R.id.bci_sceneTime);
			sceneLocation = (TextView) findViewById(R.id.bci_sceneLocation);
			sceneTemperature = (TextView) findViewById(R.id.bci_sceneTemperature);
			
			vicName.setText(getIntent().getExtras().getString("VicName"));
			vicID.setText(getIntent().getExtras().getString("VicID"));
			ioName.setText(getIntent().getExtras().getString("ioName"));
			foosName.setText(getIntent().getExtras().getString("foosName"));
			sceneTime.setText(getIntent().getExtras().getString("SceneDate")+" "+getIntent().getExtras().getString("SceneTime"));
			JSONObject job = new JSONObject(getIntent().getExtras().getString("SceneLocation"));
			JSONObject location = new JSONObject(job.getString("Location")); 
			String lat = location.getString("Latitude");
			String lon = location.getString("Longitude");
			String addr = location.getString("Address");
			sceneLocation.setText(addr+", Latitude:"+lat+", Longitude="+lon);
			sceneTemperature.setText(getIntent().getExtras().getString("SceneTemperature"));
		}catch(Exception e){e.printStackTrace();}
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.basic_case_data, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.
		int id = item.getItemId();
		if (id == R.id.action_settings) {
			return true;
		}
		return super.onOptionsItemSelected(item);
	}
	
	@Override
	public void onBackPressed() {
		// TODO Auto-generated method stub
		super.onBackPressed();
		
	}
	
	@Override
	protected void onDestroy() {
		// TODO Auto-generated method stub
		super.onDestroy();
		
	}
}
