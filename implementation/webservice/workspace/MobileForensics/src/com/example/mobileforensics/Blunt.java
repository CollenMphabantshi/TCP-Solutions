package com.example.mobileforensics;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.Date;
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
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Blunt extends Activity implements GlobalMethods{

	private LinearLayout infoLayout;
	private LinearLayout demographicsLayout;
	private LinearLayout theBodyLayout;
	private LinearLayout sceneOfInjuryLayout;
	private LinearLayout sceneLookLayout;
	private LinearLayout theSceneLayout;
	private LinearLayout galleryLayout;
	
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
	private TextView tv_rapeHomicide;
	private Spinner rapeHomicide;
	private TextView tv_suicideSuspected;
	private Spinner suicideSuspected;
	private TextView tv_previousAttempts;
	private Spinner previousAttempts;
	private TextView tv_howManyAttempts;
	private EditText howManyAttempts;
	
	private TextView sceneOfInjury;
	private TextView tv_sceneIOType;
	private Spinner sceneIOType;
	private TextView tv_whereInside;
	private Spinner sceneIType;
	private TextView tv_sceneITypeOther;
	private EditText sceneITypeOther;
	private TextView tv_doorLocked;
	private Spinner doorLocked;
	private TextView tv_windowsClosed;
	private Spinner windowsClosed;
	private TextView tv_windowsBroken;
	private Spinner windowsBroken;
	private TextView tv_victimAlone;
	private Spinner victimAlone;
	private TextView tv_peopleWithVictim;
	private EditText peopleWithVictim;
	private TextView tv_sceneOType;
	private Spinner sceneOType;
	private TextView tv_sceneOTypeOther;
	private EditText sceneOTypeOther;
	
	private TextView sceneLook;
	private TextView tv_signsOfStruggle;
	private Spinner signsOfStruggle;
	private TextView tv_alcoholBottleAround;
	private Spinner alcoholBottleAround;
	private TextView tv_drugParaphernalia;
	private Spinner drugParaphernalia;
	
	private TextView theScene;
	private TextView tv_communityAssault;
	private Spinner communityAssault;
	private TextView tv_bluntObjectUsed;
	private EditText bluntObjectUsed;
	private TextView tv_bluntForceObjectOnScene;
	private Spinner bluntForceObjectOnScene;
	private TextView tv_strangulationSuspected;
	private Spinner strangulationSuspected;
	private TextView tv_smotheringSuspected;
	private Spinner smotheringSuspected;
	private TextView tv_chockingSuspected;
	private Spinner chockingSuspected;
	private TextView tv_suicideNoteFound;
	private Spinner suicideNoteFound;
	private TextView tv_generalHistory;
	private EditText generalHistory;
	
	private TextView response;
	private Button nextButton;
	private Button doneButton;
	private Button logoutButton;
	
	private JSONObject json;
	private final static int VISIBLE = View.VISIBLE;
	private final static int INVISIBLE = View.INVISIBLE;
	private final static int GONE = View.GONE;
	private int pageCount;
	
	private String username;
	private String time;
	private String date;
	private String location;
	private String temperature;
	private JSONObject currentDataSaved;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.blunt);
		
		GlobalValues.setPages(7);
		
		pageCount = 1;
		username = "p11111111";
		Date d = new Date();
		time = ""+d.getTime();
		date = "2014-01-02";
		location = "122523, -13332";
		temperature = "23 C";
		
		infoLayout = (LinearLayout)findViewById(R.id.blunt_infoLayout);
		demographicsLayout = (LinearLayout)findViewById(R.id.blunt_demographicLayout);
		theBodyLayout = (LinearLayout)findViewById(R.id.blunt_theBodyLayout);
		sceneOfInjuryLayout = (LinearLayout)findViewById(R.id.blunt_sceneOfInjuryLayout);
		sceneLookLayout = (LinearLayout)findViewById(R.id.blunt_sceneLookLayout);
		theSceneLayout = (LinearLayout)findViewById(R.id.blunt_theSceneLayout);
		galleryLayout = (LinearLayout)findViewById(R.id.blunt_galleryLayout);
		
		tv_ioName = (TextView)findViewById(R.id.blunt_tv_io_name);
		ioName = (EditText)findViewById(R.id.blunt_io_name);
		tv_ioSurname = (TextView)findViewById(R.id.blunt_tv_io_surname);
		ioSurname = (EditText)findViewById(R.id.blunt_io_surname);
		tv_ioRank = (TextView)findViewById(R.id.blunt_tv_io_rank);
		ioRank = (EditText)findViewById(R.id.blunt_io_rank);
		tv_ioCellNo = (TextView)findViewById(R.id.blunt_tv_io_cell);
		ioCellNo = (EditText)findViewById(R.id.blunt_io_cell);
		
		tv_foosName = (TextView)findViewById(R.id.blunt_tv_foos_name);
		foosName = (EditText)findViewById(R.id.blunt_foos_name);
		tv_foosSurname = (TextView)findViewById(R.id.blunt_tv_foos_surname);
		foosSurname = (EditText)findViewById(R.id.blunt_foos_surname);
		tv_foosRank = (TextView)findViewById(R.id.blunt_tv_foos_rank);
		foosRank = (EditText)findViewById(R.id.blunt_foos_rank);
		
		tv_io = (TextView)findViewById(R.id.blunt_tv_io);
		tv_foos = (TextView)findViewById(R.id.blunt_tv_foos);
		tv_victimInfo = (TextView)findViewById(R.id.blunt_tv_victimInfo);
		tv_victimRace = (TextView)findViewById(R.id.blunt_tv_victimRace);
		tv_victimGender = (TextView)findViewById(R.id.blunt_tv_victimGender);
		
		tv_victimName = (TextView)findViewById(R.id.blunt_tv_victim_name);
		victimName = (EditText)findViewById(R.id.blunt_victim_name);
		tv_victimSurname = (TextView)findViewById(R.id.blunt_tv_victim_surname);
		victimSurname = (EditText)findViewById(R.id.blunt_victim_surname);
		tv_victimIDNo = (TextView)findViewById(R.id.blunt_tv_victim_id);
		victimIDNo = (EditText)findViewById(R.id.blunt_victim_id);
		
		rgbMale = (RadioButton)findViewById(R.id.blunt_rgbMale);
		rgbFemale = (RadioButton)findViewById(R.id.blunt_rgbFemale);
		rgbUnknownGender = (RadioButton)findViewById(R.id.blunt_rgbUnknownGender);
		
		rgbAsian = (RadioButton)findViewById(R.id.blunt_rgbAsian);
		rgbBlack = (RadioButton)findViewById(R.id.blunt_rgbBlack);
		rgbColoured = (RadioButton)findViewById(R.id.blunt_rgbColoured);
		rgbWhite = (RadioButton)findViewById(R.id.blunt_rgbWhite);
		rgbUnknownRace = (RadioButton)findViewById(R.id.blunt_rgbUnknownRace);
		
		theBody = (TextView)findViewById(R.id.blunt_tv_the_body);
		tv_bodyDecomposed = (TextView)findViewById(R.id.blunt_tv_bodyDecomposed);
		bodyDecomposed = (Spinner)findViewById(R.id.blunt_bodyDecomposed);
		tv_medicalIntervention = (TextView)findViewById(R.id.blunt_tv_medicalIntervention);
		medicalIntervention = (Spinner)findViewById(R.id.blunt_medicalIntervention);
		tv_whoFoundVictimBody = (TextView)findViewById(R.id.blunt_tv_whoFoundVictimBody);
		whoFoundVictimBody = (EditText)findViewById(R.id.blunt_whoFoundVictimBody);
		tv_closeToWater = (TextView)findViewById(R.id.blunt_tv_closeToWater);
		closeToWater = (Spinner)findViewById(R.id.blunt_closeToWater);
		tv_rapeHomicide = (TextView)findViewById(R.id.blunt_tv_rapeHomicide);
		rapeHomicide = (Spinner)findViewById(R.id.blunt_rapeHomicide);
		tv_suicideSuspected = (TextView)findViewById(R.id.blunt_tv_suicideSuspected);
		suicideSuspected = (Spinner)findViewById(R.id.blunt_suicideSuspected);
		tv_previousAttempts = (TextView)findViewById(R.id.blunt_tv_previousAttempts);
		previousAttempts = (Spinner)findViewById(R.id.blunt_previousAttempts);
		tv_howManyAttempts = (TextView)findViewById(R.id.blunt_tv_howManyAttempts);
		howManyAttempts = (EditText)findViewById(R.id.blunt_howManyAttempts);
		
		sceneOfInjury = (TextView)findViewById(R.id.blunt_sceneOfInjury);
		tv_sceneIOType = (TextView)findViewById(R.id.blunt_tv_sceneIOType);
		sceneIOType = (Spinner)findViewById(R.id.blunt_sceneIOType);
		tv_whereInside = (TextView)findViewById(R.id.blunt_tv_whereInside);
		sceneIType = (Spinner)findViewById(R.id.blunt_sceneIType);
		tv_sceneITypeOther = (TextView)findViewById(R.id.blunt_tv_sceneITypeOther);
		sceneITypeOther = (EditText)findViewById(R.id.blunt_sceneITypeOther);
		tv_doorLocked = (TextView)findViewById(R.id.blunt_tv_doorLocked);
		doorLocked = (Spinner)findViewById(R.id.blunt_doorLocked);
		tv_windowsClosed = (TextView)findViewById(R.id.blunt_tv_windowsClosed);
		windowsClosed = (Spinner)findViewById(R.id.blunt_windowsClosed);
		tv_windowsBroken = (TextView)findViewById(R.id.blunt_tv_windowsBroken);
		windowsBroken = (Spinner)findViewById(R.id.blunt_windowsBroken);
		tv_victimAlone = (TextView)findViewById(R.id.blunt_tv_victimAlone);
		victimAlone = (Spinner)findViewById(R.id.blunt_victimAlone);
		tv_peopleWithVictim = (TextView)findViewById(R.id.blunt_tv_peopleWithVictim);
		peopleWithVictim = (EditText)findViewById(R.id.blunt_peopleWithVictim);
		tv_sceneOType = (TextView)findViewById(R.id.blunt_tv_sceneOType);
		sceneOType = (Spinner)findViewById(R.id.blunt_sceneOType);
		tv_sceneOTypeOther = (TextView)findViewById(R.id.blunt_tv_sceneOTypeOther);
		sceneOTypeOther = (EditText)findViewById(R.id.blunt_sceneOTypeOther);
		
		sceneLook = (TextView)findViewById(R.id.blunt_sceneLook);
		tv_signsOfStruggle = (TextView)findViewById(R.id.blunt_tv_signsOfStruggle);
		signsOfStruggle = (Spinner)findViewById(R.id.blunt_signsOfStruggle);
		tv_alcoholBottleAround = (TextView)findViewById(R.id.blunt_tv_alcoholBottleAround);
		alcoholBottleAround = (Spinner)findViewById(R.id.blunt_alcoholBottleAround);
		tv_drugParaphernalia = (TextView)findViewById(R.id.blunt_tv_drugParaphernalia);
		drugParaphernalia = (Spinner)findViewById(R.id.blunt_drugParaphernalia);
		
		theScene = (TextView)findViewById(R.id.blunt_theScene);
		tv_communityAssault = (TextView)findViewById(R.id.blunt_tv_communityAssault);
		communityAssault = (Spinner)findViewById(R.id.blunt_communityAssault);
		tv_bluntObjectUsed = (TextView)findViewById(R.id.blunt_tv_bluntObjectUsed);
		bluntObjectUsed = (EditText)findViewById(R.id.blunt_bluntObjectUsed);
		tv_bluntForceObjectOnScene = (TextView)findViewById(R.id.blunt_tv_bluntForceObjectOnScene);
		bluntForceObjectOnScene = (Spinner)findViewById(R.id.blunt_bluntForceObjectOnScene);
		tv_strangulationSuspected = (TextView)findViewById(R.id.blunt_tv_strangulationSuspected);
		strangulationSuspected = (Spinner)findViewById(R.id.blunt_strangulationSuspected);
		tv_smotheringSuspected = (TextView)findViewById(R.id.blunt_tv_smotheringSuspected);
		smotheringSuspected = (Spinner)findViewById(R.id.blunt_smotheringSuspected);
		tv_chockingSuspected = (TextView)findViewById(R.id.blunt_tv_chockingSuspected);
		chockingSuspected = (Spinner)findViewById(R.id.blunt_chockingSuspected);
		tv_suicideNoteFound = (TextView)findViewById(R.id.blunt_tv_suicideNoteFound);
		suicideNoteFound = (Spinner)findViewById(R.id.blunt_suicideNoteFound);
		tv_generalHistory = (TextView)findViewById(R.id.blunt_tv_generalHistory);
		generalHistory = (EditText)findViewById(R.id.blunt_generalHistory);
		
		response = (TextView)findViewById(R.id.blunt_tv_response);
		nextButton = (Button)findViewById(R.id.blunt_nextButton);
		doneButton = (Button)findViewById(R.id.blunt_doneButton);
		logoutButton = (Button)findViewById(R.id.blunt_logoutButton);
		
		setOnClickEvents();
		hidePage();
		showPage();
		showHideButtons();
	}
	
	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
	}
	
	public void setOnClickEvents(){
		
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
						Toast.makeText(getApplicationContext(), "Please Fill in all Questions.", Toast.LENGTH_LONG).show();
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
				List<NameValuePair> pairs = new ArrayList<NameValuePair>();  
				
		        pairs.add(new BasicNameValuePair("rquest","addCase"));
		        pairs.add(new BasicNameValuePair("category","blunt"));
		        pairs.add(new BasicNameValuePair("caseData",currentDataSaved.toString()));
		        new Read().execute(pairs);
			}
		});
		
		/**
		 * 	Spinner onclick event
		 */
		
		
		previousAttempts.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> av, View view, int index,
					long arg3) {
				// TODO Auto-generated method stub
				try{
					TextView s = (TextView)view;
					if(s != null)
					{
						String item = (String)s.getText().toString();
						if(item.toLowerCase().equals("yes"))
						{
							tv_howManyAttempts.setVisibility(VISIBLE);
							howManyAttempts.setVisibility(VISIBLE);
						}else{
							tv_howManyAttempts.setVisibility(GONE);
							howManyAttempts.setVisibility(GONE);
						}
					}
				}catch(Exception e){
					e.printStackTrace();
				}
			}

			@Override
			public void onNothingSelected(AdapterView<?> arg0) {
				// TODO Auto-generated method stub
				
			}
			
		});
		
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
							tv_whereInside.setVisibility(GONE);
							sceneIType.setVisibility(GONE);
							tv_sceneITypeOther.setVisibility(GONE);
							sceneITypeOther.setVisibility(GONE);
							tv_doorLocked.setVisibility(GONE);
							doorLocked.setVisibility(GONE);
							tv_windowsClosed.setVisibility(GONE);
							windowsClosed.setVisibility(GONE);
							tv_windowsBroken.setVisibility(GONE);
							windowsBroken.setVisibility(GONE);
							tv_victimAlone.setVisibility(GONE);
							victimAlone.setVisibility(GONE);
							tv_peopleWithVictim.setVisibility(GONE);
							peopleWithVictim.setVisibility(GONE);
							
							tv_sceneOType.setVisibility(VISIBLE);
							sceneOType.setVisibility(VISIBLE);
							
						}else{
							tv_whereInside.setVisibility(VISIBLE);
							sceneIType.setVisibility(VISIBLE);
							tv_doorLocked.setVisibility(VISIBLE);
							doorLocked.setVisibility(VISIBLE);
							tv_windowsClosed.setVisibility(VISIBLE);
							windowsClosed.setVisibility(VISIBLE);
							tv_windowsBroken.setVisibility(VISIBLE);
							windowsBroken.setVisibility(VISIBLE);
							tv_victimAlone.setVisibility(VISIBLE);
							victimAlone.setVisibility(VISIBLE);
							
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
		
		victimAlone.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> arg0, View view,
					int arg2, long arg3) {
				// TODO Auto-generated method stub
				try{
					TextView s = (TextView)view;
					if(s != null)
					{
						String item = (String)s.getText().toString();
						if(item.toLowerCase().equals("no"))
						{
							tv_peopleWithVictim.setVisibility(VISIBLE);
							peopleWithVictim.setVisibility(VISIBLE);
						}else{
							tv_peopleWithVictim.setVisibility(GONE);
							peopleWithVictim.setVisibility(GONE);
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
	
	public void showHideButtons(){
		if(pageCount > GlobalValues.PAGES)
		{
			response.setVisibility(GONE);
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
				infoLayout.setVisibility(GONE);
				
			}
			
			//if not second page disable
			if(pageCount != 2){
				demographicsLayout.setVisibility(GONE);
			}
			
			//if not third page disable
			if(pageCount != 3){
				theBodyLayout.setVisibility(GONE);
			}
	
			//if not fourth page disable
			if(pageCount != 4){
				sceneOfInjuryLayout.setVisibility(GONE);
			}
	
			//if not fifth page disable
			if(pageCount != 5){
				sceneLookLayout.setVisibility(GONE);
			}
	
			//if not sixth page disable
			if(pageCount != 6){
				theSceneLayout.setVisibility(GONE);
			}
			
			//if not seventh page disable
			if(pageCount != 7){
				galleryLayout.setVisibility(GONE);
			}
		}catch(Exception e){e.printStackTrace();}
	}
	
	public void showPage(){
		try{
			//if first page show
			if(pageCount == 1)
			{
				infoLayout.setVisibility(VISIBLE);
				
			}
			
			//if second page show
			if(pageCount == 2){
				
				
				demographicsLayout.setVisibility(VISIBLE);
			}
			
			//if third page show
			if(pageCount == 3){
				theBodyLayout.setVisibility(VISIBLE);
			}
	
			//if not fourth page disable
			if(pageCount == 4){
				sceneOfInjuryLayout.setVisibility(VISIBLE);
			}
	
			//if fifth page show
			if(pageCount == 5){
				sceneLookLayout.setVisibility(VISIBLE);
			}
	
			//if sixth page show
			if(pageCount == 6){
				theSceneLayout.setVisibility(VISIBLE);
			}
			
			//if seventh page show
			if(pageCount == 7){
				galleryLayout.setVisibility(VISIBLE);
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
						if(!whoFoundVictimBody.getText().toString().equals(""))
						{
							String item = (String)previousAttempts.getSelectedItem();
							if(item != null){
								if(item.toLowerCase().equals("yes") && !howManyAttempts.getText().toString().equals(""))
								{
									return true;
								}else if(item.toLowerCase().equals("no")){
									return true;
								}
							}
						}
					}catch(Exception ex){
						ex.printStackTrace();
					}
					break;
				case 4:
					try{
						String siot = (String)sceneIOType.getSelectedItem();
						String sit = (String)sceneIType.getSelectedItem();
						String sot = (String)sceneOType.getSelectedItem();
						String va = (String)victimAlone.getSelectedItem();
						
						if(siot.toLowerCase().equals("inside") && !sit.toLowerCase().equals("other") && va.toLowerCase().equals("yes"))
						{
								return true;
						}else if(siot.toLowerCase().equals("inside") && !sit.toLowerCase().equals("other") && va.toLowerCase().equals("no")){
							if(!peopleWithVictim.getText().toString().equals(""))
							{
								return true;
							}
						}else if(siot.toLowerCase().equals("inside") && sit.toLowerCase().equals("other") && va.toLowerCase().equals("yes")){
							if(!sceneITypeOther.getText().toString().equals(""))
							{
								return true;
							}
						}else if(siot.toLowerCase().equals("inside") && sit.toLowerCase().equals("other") && va.toLowerCase().equals("no")){
							if(!sceneITypeOther.getText().toString().equals("") && !peopleWithVictim.getText().toString().equals(""))
							{
								return true;
							}
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
						
					}catch(Exception ex){ex.printStackTrace();}
					break;
				case 5:
					return true;
				case 6:
					try{
						if(!bluntObjectUsed.getText().toString().equals("") && !generalHistory.getText().toString().equals("")){
							return true;
						}
					}catch(Exception ex){ex.printStackTrace();}
					break;
				case 7:
					return true;
			}
		}catch(Exception e){e.printStackTrace();}
		return false;
	}
	
	public List<NameValuePair> getPostData(){
		try{
			List<NameValuePair> pairs = new ArrayList<NameValuePair>();  
	
	        pairs.add(new BasicNameValuePair("rquest","addCase"));
	        pairs.add(new BasicNameValuePair("category","blunt"));
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
	        victims.accumulate("victimSurname", victimSurname.getText().toString());
	        victims.accumulate("victimGeneralHistory", generalHistory.getText().toString());
	        victims.accumulate("scenePhoto", null);
	        victims.accumulate("bodyDecomposed", (String)bodyDecomposed.getSelectedItem());
	        victims.accumulate("medicalIntervention", (String)medicalIntervention.getSelectedItem());
	        victims.accumulate("bodyBurned", null);
	        victims.accumulate("bodyIntact", null);
	        victims.accumulate("whoFoundVictimBody", whoFoundVictimBody.getText().toString());
	        victims.accumulate("victimFoundCloseToWater", (String)closeToWater.getSelectedItem());
	        victims.accumulate("suicideSuspected", (String)suicideSuspected.getSelectedItem());
	        victims.accumulate("victimSuicideNoteFound", (String)suicideNoteFound.getSelectedItem());
	        victims.accumulate("previousAttempts", (String)previousAttempts.getSelectedItem());
	        victims.accumulate("numberOfPreviousAttempts", getAttempts());
	        victims.accumulate("rapeHomicideSuspected", (String)rapeHomicide.getSelectedItem());
	        String item = (String)sceneIOType.getSelectedItem();
	        if(item.toLowerCase().equals("inside"))
	        {
		        victims.accumulate("victimInside", "yes");
		        victims.accumulate("victimOutside", "no");
	        }else{
	        	victims.accumulate("victimInside", "no");
		        victims.accumulate("victimOutside", "yes");
	        }
	       
	        vicArray.put(victims);
	        info.accumulate("victims", vicArray);
	        
	        info.accumulate("bluntIOType",getIOType() );
	        info.accumulate("signsOfStruggle", (String)signsOfStruggle.getSelectedItem());
	        info.accumulate("alcoholBottleAround", (String)alcoholBottleAround.getSelectedItem());
	        info.accumulate("drugParaphernalia", (String)drugParaphernalia.getSelectedItem());
	        info.accumulate("strangulationSuspected", (String)strangulationSuspected.getSelectedItem());
	        info.accumulate("smotheringSuspected", (String)smotheringSuspected.getSelectedItem());
	        info.accumulate("chockingSuspected", (String)chockingSuspected.getSelectedItem());
	        info.accumulate("doorLocked", (String)doorLocked.getSelectedItem());
	        info.accumulate("windowsClosed", (String)windowsClosed.getSelectedItem());
	        info.accumulate("windowsBroken", (String)windowsBroken.getSelectedItem());
	        info.accumulate("victimAlone", (String)victimAlone.getSelectedItem());
	        info.accumulate("peopleWithVictim", getPeopleWithVictim());
	        info.accumulate("bluntForceObjectSuspected", bluntObjectUsed.getText().toString());
	        info.accumulate("bluntForceObjectStillOnScene", (String)bluntForceObjectOnScene.getSelectedItem());
	        info.accumulate("wasCommunityAssult", (String)communityAssault.getSelectedItem());
	        
	        array.put(info);
	        obj.accumulate("object", array);
	        currentDataSaved = obj;
	        
	        pairs.add(new BasicNameValuePair("caseData",obj.toString()));
	        
	        return pairs;
		}catch(Exception e){
			e.printStackTrace();
			return null;
		}
	}
	
	public String getIOType(){
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
	
	public String getVictimGender(){
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
	
	public String getVictimRace(){
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
	
	public void knownVictim(){
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
	
	public int getAttempts(){
		try{
			String item = (String)previousAttempts.getSelectedItem();
			if(item.toLowerCase().equals("yes"))
			{
				int attempts = Integer.parseInt(howManyAttempts.getText().toString());
				return attempts;
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		return 0;
	}
	
	public String getPeopleWithVictim(){
		try{
			
			String item = (String)victimAlone.getSelectedItem();
			if(item.toLowerCase().equals("no"))
			{
				return peopleWithVictim.getText().toString();
			}else{
				
				return null;
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		return null;
	}
	public void saveDataOnAction() throws Exception{
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
        victims.accumulate("victimSurname", victimSurname.getText().toString());
        victims.accumulate("victimGeneralHistory", generalHistory.getText().toString());
        victims.accumulate("scenePhoto", null);
        victims.accumulate("bodyDecomposed", (String)bodyDecomposed.getSelectedItem());
        victims.accumulate("medicalIntervention", (String)medicalIntervention.getSelectedItem());
        victims.accumulate("bodyBurned", null);
        victims.accumulate("bodyIntact", null);
        victims.accumulate("whoFoundVictimBody", whoFoundVictimBody.getText().toString());
        victims.accumulate("victimFoundCloseToWater", (String)closeToWater.getSelectedItem());
        victims.accumulate("suicideSuspected", (String)suicideSuspected.getSelectedItem());
        victims.accumulate("victimSuicideNoteFound", (String)suicideNoteFound.getSelectedItem());
        victims.accumulate("previousAttempts", (String)previousAttempts.getSelectedItem());
        victims.accumulate("numberOfPreviousAttempts", getAttempts());
        victims.accumulate("rapeHomicideSuspected", (String)rapeHomicide.getSelectedItem());
        String item = (String)sceneIOType.getSelectedItem();
        if(item.toLowerCase().equals("inside"))
        {
	        victims.accumulate("victimInside", "yes");
	        victims.accumulate("victimOutside", "no");
        }else{
        	victims.accumulate("victimInside", "no");
	        victims.accumulate("victimOutside", "yes");
        }
       
        vicArray.put(victims);
        info.accumulate("victims", vicArray);
        
        info.accumulate("bluntIOType",getIOType() );
        info.accumulate("signsOfStruggle", (String)signsOfStruggle.getSelectedItem());
        info.accumulate("alcoholBottleAround", (String)alcoholBottleAround.getSelectedItem());
        info.accumulate("drugParaphernalia", (String)drugParaphernalia.getSelectedItem());
        info.accumulate("strangulationSuspected", (String)strangulationSuspected.getSelectedItem());
        info.accumulate("smotheringSuspected", (String)smotheringSuspected.getSelectedItem());
        info.accumulate("chockingSuspected", (String)chockingSuspected.getSelectedItem());
        info.accumulate("doorLocked", (String)doorLocked.getSelectedItem());
        info.accumulate("windowsClosed", (String)windowsClosed.getSelectedItem());
        info.accumulate("windowsBroken", (String)windowsBroken.getSelectedItem());
        info.accumulate("victimAlone", (String)victimAlone.getSelectedItem());
        info.accumulate("peopleWithVictim", getPeopleWithVictim());
        info.accumulate("bluntForceObjectSuspected", bluntObjectUsed.getText().toString());
        info.accumulate("bluntForceObjectStillOnScene", (String)bluntForceObjectOnScene.getSelectedItem());
        info.accumulate("wasCommunityAssult", (String)communityAssault.getSelectedItem());
        
        array.put(info);
        obj.accumulate("object", array);
        currentDataSaved = obj;
        
	}
	public void saveData(JSONObject data) throws Exception{
		
		System.out.println("SAVED: "+data.toString());
		
	}
	
	public void resendData() throws Exception{
		
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
				json = request(GlobalValues.WS_URL, params[0]);
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
			try{
				if(result != null)
				{
					String status = result.getString("status");
					String message = result.getString("msg");
					System.out.println("STATUS: "+status);
					System.out.println("MESSAGE: "+message);
					response.setVisibility(VISIBLE);
					if(status.toLowerCase().equals("failed"))
					{
						response.setText(message);
						saveData(currentDataSaved);
					}else{
						response.setText(message);
					}
				}
			}catch(Exception e){
				
			}
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
