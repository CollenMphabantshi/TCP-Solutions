package com.example.mobileforensics;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.HTTP;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Foetusabandonedbaby extends Activity{

	private TextView tv_ioName;
	private EditText ioName;
	private TextView tv_ioSurname;
	private EditText ioSurname;
	private TextView tv_ioRank;
	private EditText ioRank;
	private TextView tv_ioCellNo;
	private EditText ioCellNo;
	
	private TextView tv_foosName;
	private EditText foosName;
	private TextView tv_foosSurname;
	private EditText foosSurname;
	private TextView tv_foosRank;
	private EditText foosRank;
	
	private TextView tv_victimName;
	private EditText victimName;
	private TextView tv_victimSurname;
	private EditText victimSurname;
	private TextView tv_victimIDNo;
	private EditText victimIDNo;
	
	private TextView tv_victimInfo;
	private TextView tv_victimRace;
	private TextView tv_victimGender;
	private TextView tv_foos;
	private TextView tv_io;
	
	
	private RadioButton rgbMale;
	private RadioButton rgbFemale;
	private RadioButton rgbUnknownGender;
	
	private RadioButton rgbAsian;
	private RadioButton rgbBlack;
	private RadioButton rgbColoured;
	private RadioButton rgbWhite;
	private RadioButton rgbUnknownRace;

	private TextView theBody;
	private TextView tv_bodyDecomposed;
	private Spinner bodyDecomposed;
	private TextView tv_medicalIntervention;
	private Spinner medicalIntervention;
	private TextView tv_whoFoundVictimBody;
	private EditText whoFoundVictimBody;
	private TextView tv_closeToWater;
	private Spinner closeToWater;
	
	private TextView sceneOfInjury;
	private TextView tv_sceneIOType;
	private Spinner sceneIOType;
	private TextView tv_sceneIType;
	private Spinner sceneIType;
	private TextView tv_sceneITypeOther;
	private EditText sceneITypeOther;
	private TextView tv_sceneOType;
	private Spinner sceneOType;
	private TextView tv_sceneOTypeOther;
	private EditText sceneOTypeOther;
	
	private TextView theScene;
	private TextView tv_generalHistory;
	private EditText generalHistory;
	
	private RelativeLayout rl1;
	private Button nextButton;
	private Button doneButton;
	private Button logoutButton;
	
	private JSONObject json;
	private final static String WS_URL = "https://192.168.56.1/ws/models/api.php";
	private final static int PAGES = 6;
	private final static int VISIBLE = View.VISIBLE;
	private final static int INVISIBLE = View.INVISIBLE;
	private final static int GONE = View.GONE;
	private int pageCount;
	
	private String username;
	private String time;
	private String date;
	private String location;
	private String temperature;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.foetusabandoned);
		
		pageCount = 1;
		username = "p11111111";
		time = "00:00:10";
		date = "2014-01-01";
		location = "122223, -13332";
		temperature = "23 C";
		
		tv_ioName = (TextView)findViewById(R.id.foetus_tv_io_name);
		ioName = (EditText)findViewById(R.id.foetus_io_name);
		tv_ioSurname = (TextView)findViewById(R.id.tv_foetus_io_surname);
		ioSurname = (EditText)findViewById(R.id.foetus_io_surname);
		tv_ioRank = (TextView)findViewById(R.id.tv_foetus_io_rank);
		ioRank = (EditText)findViewById(R.id.foetus_io_rank);
		tv_ioCellNo = (TextView)findViewById(R.id.tv_foetus_io_cell);
		ioCellNo = (EditText)findViewById(R.id.foetus_io_cell);
		
		tv_foosName = (TextView)findViewById(R.id.tv_foetus_foos_name);
		foosName = (EditText)findViewById(R.id.foetus_foos_name);
		tv_foosSurname = (TextView)findViewById(R.id.tv_foetus_foos_surname);
		foosSurname = (EditText)findViewById(R.id.foetus_foos_surname);
		tv_foosRank = (TextView)findViewById(R.id.tv_foetus_foos_rank);
		foosRank = (EditText)findViewById(R.id.foetus_foos_rank);
		
		tv_io = (TextView)findViewById(R.id.foetus_tv_io);
		tv_foos = (TextView)findViewById(R.id.foetus_tv_foosInfo);
		tv_victimInfo = (TextView)findViewById(R.id.foetus_tv_victimInfo);
		tv_victimRace = (TextView)findViewById(R.id.foetus_tv_victimRace);
		tv_victimGender = (TextView)findViewById(R.id.foetus_tv_victimGender);
		
		tv_victimName = (TextView)findViewById(R.id.tv_foetus_victim_name);
		victimName = (EditText)findViewById(R.id.foetus_victim_name);
		tv_victimSurname = (TextView)findViewById(R.id.tv_foetus_victim_surname);
		victimSurname = (EditText)findViewById(R.id.foetus_victim_surname);
		tv_victimIDNo = (TextView)findViewById(R.id.tv_foetus_victim_id);
		victimIDNo = (EditText)findViewById(R.id.foetus_victim_id);
		
		rgbMale = (RadioButton)findViewById(R.id.foetus_rgbMale);
		rgbFemale = (RadioButton)findViewById(R.id.foetus_rgbFemale);
		rgbUnknownGender = (RadioButton)findViewById(R.id.foetus_rgbUnknownGender);
		
		rgbAsian = (RadioButton)findViewById(R.id.foetus_rgbAsian);
		rgbBlack = (RadioButton)findViewById(R.id.foetus_rgbBlack);
		rgbColoured = (RadioButton)findViewById(R.id.foetus_rgbColoured);
		rgbWhite = (RadioButton)findViewById(R.id.foetus_rgbWhite);
		rgbUnknownRace = (RadioButton)findViewById(R.id.foetus_rgbUnknownRace);
		
		theBody = (TextView)findViewById(R.id.foetus_tv_the_body);
		tv_bodyDecomposed = (TextView)findViewById(R.id.tv_foetus_bodyDecomposed);
		bodyDecomposed = (Spinner)findViewById(R.id.foetus_bodyDecomposed);
		tv_medicalIntervention = (TextView)findViewById(R.id.tv_foetus_medicalIntervention);
		medicalIntervention = (Spinner)findViewById(R.id.foetus_medicalIntervention);
		tv_whoFoundVictimBody = (TextView)findViewById(R.id.tv_foetus_whoFoundVictimBody);
		whoFoundVictimBody = (EditText)findViewById(R.id.foetus_whoFoundVictimBody);
		tv_closeToWater = (TextView)findViewById(R.id.tv_foetus_closeToWater);
		closeToWater = (Spinner)findViewById(R.id.foetus_closeToWater);
		
		sceneOfInjury = (TextView)findViewById(R.id.foetus_sceneOfInjury);
		tv_sceneIOType = (TextView)findViewById(R.id.foetus_tv_sceneIOType);
		sceneIOType = (Spinner)findViewById(R.id.foetus_sceneIOType);
		tv_sceneIType = (TextView)findViewById(R.id.tv_foetus_sceneIType);
		sceneIType = (Spinner)findViewById(R.id.foetus_sceneIType);
		tv_sceneITypeOther = (TextView)findViewById(R.id.tv_foetus_sceneITypeOther);
		sceneITypeOther = (EditText)findViewById(R.id.foetus_sceneITypeOther);
		tv_sceneOType = (TextView)findViewById(R.id.tv_foetus_sceneOType);
		sceneOType = (Spinner)findViewById(R.id.foetus_sceneOType);
		tv_sceneOTypeOther = (TextView)findViewById(R.id.tv_foetus_sceneOTypeOther);
		sceneOTypeOther = (EditText)findViewById(R.id.foetus_sceneOTypeOther);
		
		theScene = (TextView)findViewById(R.id.foetus_theScene);
		tv_generalHistory = (TextView)findViewById(R.id.tv_foetus_generalHistory);
		generalHistory = (EditText)findViewById(R.id.foetus_generalHistory);
		
		
		nextButton = (Button)findViewById(R.id.foetus_nextButton);
		doneButton = (Button)findViewById(R.id.foetus_doneButton);
		logoutButton = (Button)findViewById(R.id.foetus_logoutButton);
		
		setOnClickEvents();
		hidePage();
		showPage();
		showHideButtons();
	}
	
	private void setOnClickEvents(){
		
		nextButton.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View view) {
				// TODO Auto-generated method stub
				try{
					System.out.println("Page: "+pageCount);
					if(validateNextPage())
					{
						pageCount++;
						hidePage();
						showPage();
						showHideButtons();
					}else{
						//Toast.makeText(foetus.this, "Please Fill in all Questions.", Toast.LENGTH_LONG);
					}
					
				}catch(Exception e){e.printStackTrace();}
			}
		});
		
		doneButton.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View view) {
				// TODO Auto-generated method stub
				try{
					//submit data to the server
					List<NameValuePair> postdata = getPostData();
					if(postdata != null)
					{
						new Read().execute(postdata);
						if(json != null)
						{
							System.out.println("\n\n\n\n\n\n\n\nOUTPUT: "+json.toString()+"\n\n\n\n\n\n\n\n");
						}
					}
					
					
					nextButton.setVisibility(GONE);
					doneButton.setVisibility(GONE);
					logoutButton.setVisibility(VISIBLE);
				}catch(Exception e){e.printStackTrace();}
			}
		});
		
		logoutButton.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View view) {
				// TODO Auto-generated method stub
				
			}
		});
		
		/**
		 * 	Spinner onclick event
		 */
		
		sceneIOType.setOnItemSelectedListener(new OnItemSelectedListener() {
			
			@Override
			public void onItemSelected(AdapterView<?> av, View view, int index,
					long arg3) {
				// TODO Auto-generated method stub
				try{
					TextView s = (TextView)view;
					if(s != null)
					{
						String item = (String)s.getText().toString();
						if(item.toLowerCase().equals("outside"))
						{
							tv_sceneIType.setVisibility(GONE);
							sceneIType.setVisibility(GONE);
							tv_sceneITypeOther.setVisibility(GONE);
							sceneITypeOther.setVisibility(GONE);
							tv_sceneOType.setVisibility(VISIBLE);
							sceneOType.setVisibility(VISIBLE);
							
						}else{
							tv_sceneIType.setVisibility(VISIBLE);
							sceneIType.setVisibility(VISIBLE);
							tv_sceneOType.setVisibility(GONE);
							sceneOType.setVisibility(GONE);
							tv_sceneOTypeOther.setVisibility(GONE);
							sceneOTypeOther.setVisibility(GONE);
						}
					}
				}catch(Exception e){e.printStackTrace();}
			}

			@Override
			public void onNothingSelected(AdapterView<?> arg0) {
				// TODO Auto-generated method stub
				
			}
		});
		
		sceneIType.setOnItemSelectedListener(new OnItemSelectedListener() {
			
			@Override
			public void onItemSelected(AdapterView<?> av, View view, int index,
					long arg3) {
				// TODO Auto-generated method stub
				try{
					TextView s = (TextView)view;
					if(s != null)
					{
						String item = (String)s.getText().toString();
						if(item.toLowerCase().equals("other"))
						{
							tv_sceneITypeOther.setVisibility(VISIBLE);
							sceneITypeOther.setVisibility(VISIBLE);
						}else{
							tv_sceneITypeOther.setVisibility(GONE);
							sceneITypeOther.setVisibility(GONE);
						}
					}
				}catch(Exception e){e.printStackTrace();}
			}

			@Override
			public void onNothingSelected(AdapterView<?> arg0) {
				// TODO Auto-generated method stub
				
			}
		});
		sceneOType.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> arg0, View view,
					int arg2, long arg3) {
				// TODO Auto-generated method stub
				try{
					TextView s = (TextView)view;
					if(s != null)
					{
						String item = (String)s.getText();
						if(item.toLowerCase().equals("other"))
						{
							tv_sceneOTypeOther.setVisibility(VISIBLE);
							sceneOTypeOther.setVisibility(VISIBLE);
						}else{
							tv_sceneOTypeOther.setVisibility(GONE);
							sceneOTypeOther.setVisibility(GONE);
						}
					}
				}catch(Exception e){e.printStackTrace();}
			}

			@Override
			public void onNothingSelected(AdapterView<?> arg0) {
				// TODO Auto-generated method stub
				
			}
		});
		
	}
	
	private void showHideButtons(){
		if(pageCount > PAGES)
		{
			nextButton.setVisibility(GONE);
			doneButton.setVisibility(VISIBLE);
			logoutButton.setVisibility(GONE);
		}
	}
	public void hidePage(){
		try{
			//if not first page disable
			if(pageCount != 1)
			{
				//rl1.setVisibility(GONE);
				tv_io.setVisibility(GONE);
				tv_foos.setVisibility(GONE);
				tv_ioName.setVisibility(GONE);
				ioName.setVisibility(GONE);
				tv_ioSurname.setVisibility(GONE);
				ioSurname.setVisibility(GONE);
				tv_ioRank.setVisibility(GONE);
				ioRank.setVisibility(GONE);
				tv_ioCellNo.setVisibility(GONE);
				ioCellNo.setVisibility(GONE);
				
				tv_foosName.setVisibility(GONE);
				foosName.setVisibility(GONE);
				tv_foosSurname.setVisibility(GONE);
				foosSurname.setVisibility(GONE);
				tv_foosRank.setVisibility(GONE);
				foosRank.setVisibility(GONE);
				
			}
			
			//if not second page disable
			if(pageCount != 2){
				
				
				tv_victimName.setVisibility(GONE);
				victimName.setVisibility(GONE);
				tv_victimSurname.setVisibility(GONE);
				victimSurname.setVisibility(GONE);
				tv_victimIDNo.setVisibility(GONE);
				victimIDNo.setVisibility(GONE);
				
				
				rgbMale.setVisibility(GONE);
				rgbFemale.setVisibility(GONE);
				rgbUnknownGender.setVisibility(GONE);
				
				
				rgbAsian.setVisibility(GONE);
				rgbBlack.setVisibility(GONE);
				rgbColoured.setVisibility(GONE);
				rgbWhite.setVisibility(GONE);
				rgbUnknownRace.setVisibility(GONE);
				tv_victimInfo.setVisibility(GONE);
				tv_victimRace.setVisibility(GONE);
				tv_victimGender.setVisibility(GONE);
			}
			
			//if not third page disable
			if(pageCount != 3){
				theBody.setVisibility(GONE);
				tv_bodyDecomposed.setVisibility(GONE);
				bodyDecomposed.setVisibility(GONE);
				tv_medicalIntervention.setVisibility(GONE);
				medicalIntervention.setVisibility(GONE);
				tv_whoFoundVictimBody.setVisibility(GONE);
				whoFoundVictimBody.setVisibility(GONE);
				tv_closeToWater.setVisibility(GONE);
				closeToWater.setVisibility(GONE);
			}
	
			//if not fourth page disable
			if(pageCount != 4){
				sceneOfInjury.setVisibility(GONE);
				tv_sceneIOType.setVisibility(GONE);
				sceneIOType.setVisibility(GONE);
				tv_sceneIType.setVisibility(GONE);
				sceneIType.setVisibility(GONE);
				tv_sceneITypeOther.setVisibility(GONE);
				sceneITypeOther.setVisibility(GONE);
				tv_sceneOType.setVisibility(GONE);
				sceneOType.setVisibility(GONE);
				tv_sceneOTypeOther.setVisibility(GONE);
				sceneOTypeOther.setVisibility(GONE);
			}
	
			//if not sixth page disable
			if(pageCount != 5){
				theScene.setVisibility(GONE);
				tv_generalHistory.setVisibility(GONE);
				generalHistory.setVisibility(GONE);
			}
		}catch(Exception e){e.printStackTrace();}
	}
	
	public void showPage(){
		try{
			//if fist page show
			if(pageCount == 1)
			{
				tv_io.setVisibility(VISIBLE);
				tv_foos.setVisibility(VISIBLE);
				tv_ioName.setVisibility(VISIBLE);
				ioName.setVisibility(VISIBLE);
				tv_ioSurname.setVisibility(VISIBLE);
				ioSurname.setVisibility(VISIBLE);
				tv_ioRank.setVisibility(VISIBLE);
				ioRank.setVisibility(VISIBLE);
				tv_ioCellNo.setVisibility(VISIBLE);
				ioCellNo.setVisibility(VISIBLE);
				
				tv_foosName.setVisibility(VISIBLE);
				foosName.setVisibility(VISIBLE);
				tv_foosSurname.setVisibility(VISIBLE);
				foosSurname.setVisibility(VISIBLE);
				tv_foosRank.setVisibility(VISIBLE);
				foosRank.setVisibility(VISIBLE);
			
			}
			
			//if second page show
			if(pageCount == 2){
				
				tv_victimName.setVisibility(VISIBLE);
				victimName.setVisibility(VISIBLE);
				tv_victimSurname.setVisibility(VISIBLE);
				victimSurname.setVisibility(VISIBLE);
				tv_victimIDNo.setVisibility(VISIBLE);
				victimIDNo.setVisibility(VISIBLE);
				
				rgbMale.setVisibility(VISIBLE);
				rgbFemale.setVisibility(VISIBLE);
				rgbUnknownGender.setVisibility(VISIBLE);
				
				rgbAsian.setVisibility(VISIBLE);
				rgbBlack.setVisibility(VISIBLE);
				rgbColoured.setVisibility(VISIBLE);
				rgbWhite.setVisibility(VISIBLE);
				rgbUnknownRace.setVisibility(VISIBLE);
				
				tv_victimInfo.setVisibility(VISIBLE);
				tv_victimRace.setVisibility(VISIBLE);
				tv_victimGender.setVisibility(VISIBLE);
			}
			
			//if third page show
			if(pageCount == 3){
				
				theBody.setVisibility(VISIBLE);
				tv_bodyDecomposed.setVisibility(VISIBLE);
				bodyDecomposed.setVisibility(VISIBLE);
				tv_medicalIntervention.setVisibility(VISIBLE);
				medicalIntervention.setVisibility(VISIBLE);
				tv_whoFoundVictimBody.setVisibility(VISIBLE);
				whoFoundVictimBody.setVisibility(VISIBLE);
				tv_closeToWater.setVisibility(VISIBLE);
				closeToWater.setVisibility(VISIBLE);
			}
	
			//if fourth page show
			if(pageCount == 4){
				sceneOfInjury.setVisibility(VISIBLE);
				tv_sceneIOType.setVisibility(VISIBLE);
				sceneIOType.setVisibility(VISIBLE);
			}
			//if sixth page show
			if(pageCount == 5){
				theScene.setVisibility(VISIBLE);
				tv_generalHistory.setVisibility(VISIBLE);
				generalHistory.setVisibility(VISIBLE);
			}
		}catch(Exception e){e.printStackTrace();}
	}
	
	
	public boolean validateNextPage(){
		try{
			switch(pageCount)
			{
				case 1:
					if(!ioName.getText().toString().equals("") && !ioSurname.getText().toString().equals("") && !ioRank.getText().toString().equals("")
							&& !ioCellNo.getText().toString().equals("") && !foosName.getText().toString().equals("") && !foosSurname.getText().toString().equals("")
							&& !foosRank.getText().toString().equals("")){
						return true;
					}
					break;
				case 2:
					if(((!victimName.getText().toString().equals("") && !victimSurname.getText().toString().equals("") && !victimIDNo.getText().toString().equals(""))
						|| (victimName.getText().toString().equals("") && victimSurname.getText().toString().equals("") && victimIDNo.getText().toString().equals("")))	
							&& (rgbMale.isChecked() || rgbFemale.isChecked() ||rgbUnknownGender.isChecked())
							&& (rgbAsian.isChecked() || rgbBlack.isChecked() || rgbColoured.isChecked()
								|| rgbWhite.isChecked() || rgbUnknownRace.isChecked())){
						
						return true;
					}
					break;
				case 3:
					try{
						String siot = (String)sceneIOType.getSelectedItem();
						String sit = (String)sceneIType.getSelectedItem();
						String sot = (String)sceneOType.getSelectedItem();
						
						
						if(siot.toLowerCase().equals("inside") && !sit.toLowerCase().equals("other"))
						{
								return true;
						}else if(siot.toLowerCase().equals("inside") && !sit.toLowerCase().equals("other")){
							
								return true;
							
						}else if(siot.toLowerCase().equals("inside") && sit.toLowerCase().equals("other")){
							if(!sceneITypeOther.getText().toString().equals(""))
							{
								return true;
							}
						}else if(siot.toLowerCase().equals("inside") && sit.toLowerCase().equals("other")){
							
								return true;
							
						}
						////
						else if(siot.toLowerCase().equals("outside") && !sot.toLowerCase().equals("other"))
						{
							return true;
						}else if(siot.toLowerCase().equals("outside") && sot.toLowerCase().equals("other")){
							if(!sceneOTypeOther.getText().toString().equals(""))
							{
								return true;
							}
						}
						
					}catch(Exception ex){}
					break;
				case 4:
					return true;
				case 5:
					try{
						if(!generalHistory.getText().toString().equals("")){
							return true;
						}
					}catch(Exception ex){}
					break;
			}
		}catch(Exception e){e.printStackTrace();}
		return false;
	}
	
	private List<NameValuePair> getPostData(){
		try{
			List<NameValuePair> pairs = new ArrayList<NameValuePair>();  
	
	        pairs.add(new BasicNameValuePair("rquest","addCase"));
	        pairs.add(new BasicNameValuePair("category","foetus"));
	        JSONObject obj = new JSONObject();
	        JSONArray array = new JSONArray();
	        JSONObject info = new JSONObject();
	        JSONArray vicArray = new JSONArray();
	        JSONObject victims = new JSONObject();
	        
	        
	        info.accumulate("FOPersonelNumber", username);
	        info.accumulate("sceneTime", time);
	        info.accumulate("sceneDate", date);
	        info.accumulate("sceneLocation", location);
	        info.accumulate("sceneTemparature", temperature);
	        info.accumulate("investigatingOfficerName", ioName.getText().toString());
	        info.accumulate("investigatingOfficerRank", ioRank.getText().toString());
	        info.accumulate("investigatingOfficerCellNo", ioCellNo.getText().toString());
	        info.accumulate("firstOfficerOnSceneName", foosName.getText().toString());
	        info.accumulate("firstOfficerOnSceneRank", foosRank.getText().toString());
	        knownVictim();
	        victims.accumulate("victimIdentityNumber", victimIDNo.getText().toString());
	        victims.accumulate("victimGender", getVictimGender());
	        victims.accumulate("victimRace", getVictimRace());
	        victims.accumulate("victimName", victimName.getText().toString());
	        victims.accumulate("victimSurame", victimSurname.getText().toString());
	        victims.accumulate("scenePhoto", null);
	        victims.accumulate("bodyDecomposed", (String)bodyDecomposed.getSelectedItem());
	        victims.accumulate("medicalIntervention", (String)medicalIntervention.getSelectedItem());
	        victims.accumulate("whoFoundVictimBody", whoFoundVictimBody.getText().toString());
	        victims.accumulate("victimFoundCloseToWater", (String)closeToWater.getSelectedItem());
	        String item = (String)sceneIOType.getSelectedItem();
	        if(item.toLowerCase().equals("yes"))
	        {
		        victims.accumulate("victimInside", "yes");
		        victims.accumulate("victimOutside", "no");
	        }
	       
	        vicArray.put(victims);
	        info.accumulate("victims", vicArray);
	        
	        info.accumulate("foetusIOType",getIOType() );
	        
	        array.put(info);
	        obj.accumulate("object", array);
	        pairs.add(new BasicNameValuePair("caseData",obj.toString()));
	        
	        return pairs;
		}catch(Exception e){
			e.printStackTrace();
			return null;
		}
	}
	
	private String getIOType(){
		try{
			String type = "";
			String item = (String)sceneIOType.getSelectedItem();
			if(item.toLowerCase().equals("inside"))
			{
				type = (String)sceneIType.getSelectedItem();
				if(type.toLowerCase().equals("other")){
					type = sceneITypeOther.getText().toString();
				}
				return type;
			}else{
				type = (String)sceneOType.getSelectedItem();
				if(type.toLowerCase().equals("other")){
					type = sceneOTypeOther.getText().toString();
				}
				return type;
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		return null;
	}
	
	private String getVictimGender(){
		try{
			
			
			if(rgbMale.isChecked())
			{
				return "Male";
			}else if(rgbFemale.isChecked())
			{
				return "Female";
			}else if(rgbUnknownGender.isChecked())
			{
				return "Unknown";
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		return "Unknown";
	}
	
	private String getVictimRace(){
		try{
			
			
			if(rgbAsian.isChecked())
			{
				return "Asian";
			}else if(rgbBlack.isChecked())
			{
				return "Black";
			}else if(rgbColoured.isChecked())
			{
				return "Coloured";
			}else if(rgbWhite.isChecked())
			{
				return "White";
			}else if(rgbUnknownRace.isChecked())
			{
				return "Unknown";
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		return "Unknown";
	}
	
	private void knownVictim(){
		try{
			if(victimName.getText().toString().equals(""))
			{
				victimName.setText("Unknown");
				victimSurname.setText("Unknown");
				victimIDNo.setText("Unknown");
			}
		}catch(Exception e){
			e.printStackTrace();
		}
	}
	
	public JSONObject request(String url, List<NameValuePair> request)
            throws ClientProtocolException, IOException, IllegalStateException,
            JSONException {
		
        	DefaultHttpClient client = (DefaultHttpClient) WebServiceWrapper.getNewHttpClient();
            HttpPost post = new HttpPost(url);
            
            UrlEncodedFormEntity entity = new UrlEncodedFormEntity(request,HTTP.UTF_8);
            post.setEntity(entity);
            
            HttpResponse response = client.execute(post);
            
            Scanner in = new Scanner(response.getEntity().getContent());
            String line ="";
            
            while(in.hasNextLine()){
            	line += in.nextLine();
            }
            
            JSONObject tmp = new JSONObject(line);
            in.close();
            return tmp;
    }
    
    
    
    public class Read extends AsyncTask<List<NameValuePair>, Integer,JSONObject>{

		@Override
		protected JSONObject doInBackground(List<NameValuePair>... params) {
			// TODO Auto-generated method stub
			try {
				json = request(WS_URL, params[0]);
			} catch (ClientProtocolException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IllegalStateException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (JSONException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			return json;
		}
		
		@Override
		protected void onPostExecute(JSONObject result) {
			// TODO Auto-generated method stub
			super.onPostExecute(result);
			
		}
	
    }
    
    public class LoadMethods extends AsyncTask<String, Integer,Boolean>{

		@Override
		protected Boolean doInBackground(String... params) {
			boolean status = false; 
			try{
			// TODO Auto-generated method stub
			
				if(params[0] != null){
					
					return true;
				}
			
			}catch(Exception e){e.printStackTrace();}
			return status;
		}
		
		@Override
		protected void onPostExecute(Boolean result) {
			// TODO Auto-generated method stub
			super.onPostExecute(result);
			
		}
	
    }

}
