package com.example.mobileforensics;

import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Locale;
import java.util.Random;
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


import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.GoogleMap.OnMyLocationChangeListener;


import android.app.Activity;
import android.app.Dialog;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.Space;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Toast;

public class Hanging extends Activity implements OnMyLocationChangeListener{

	private LinearLayout infoLayout;
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
	
	private LinearLayout demographicsLayout;
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

	private LinearLayout theBodyLayout;
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
	
	private LinearLayout sceneOfInjuryLayout;
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
	
	private LinearLayout sceneLookLayout;
	private TextView sceneLook;
	private TextView tv_signsOfStruggle;
	private Spinner signsOfStruggle;
	private TextView tv_alcoholBottleAround;
	private Spinner alcoholBottleAround;
	private TextView tv_drugParaphernalia;
	private Spinner drugParaphernalia;
	
	private LinearLayout theSceneLayout;
	private TextView theScene;
	private TextView tv_autoeroticAsphyxia;
	private Spinner autoeroticAsphyxia;
	private TextView tv_partialHanging;
	private Spinner partialHanging;
	private TextView tv_partialHangingOther;
	private EditText partialHangingOther;
	private TextView tv_completeHanging;
	private Spinner completeHanging;
	private TextView tv_ligatureAroundNeck;
	private Spinner ligatureAroundNeck;
	private TextView tv_whoRemovedligature;
	private EditText whoRemovedligature;
	private TextView tv_ligatureType;
	private Spinner ligatureType;
	private TextView tv_ligatureTypeOther;
	private EditText ligatureTypeOther;
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
	
	private LinearLayout galleryLayout;
	
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
	
	GoogleMap map;
	private JSONObject locate;
	private double longitude;
	private double latitude;
	private int status;
	private String myAddress;
	private String Text;
	private TextView value;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.hanging);
		
		GlobalValues.setPages(7);
		
		
		status = GooglePlayServicesUtil.isGooglePlayServicesAvailable(getBaseContext());
		
		initializeVariables();
		
		initialize();
		
		setOnClickEvents();
		hidePage();
		showPage();
		showHideButtons();
	}
	
	public void initialize(){
		
		if( status != ConnectionResult.SUCCESS){
			int requestCode = 10;
			Dialog dialog = GooglePlayServicesUtil.getErrorDialog(status, this, requestCode);
			dialog.show();
		}else{
			
			map = ((MapFragment) getFragmentManager().findFragmentById(R.id.fragId)).getMap();
			map.setMyLocationEnabled(true);
			map.setOnMyLocationChangeListener(this);
			
		}
		
	}

@Override
public void onMyLocationChange(Location loc) {
	// TODO Auto-generated method stub
	
	locate = new JSONObject();
	JSONObject object = new JSONObject();
	//get geolactions, time and date
	longitude = loc.getLongitude();
	latitude = loc.getLatitude();
	Calendar c = Calendar.getInstance();
    SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    String formattedDate = df.format(c.getTime());
    /*time = formattedDate.substring(11);
    date = formattedDate.substring(0,11);
	temperature = "23 C";*/
    getAddress(longitude,latitude);
    
    try {
		locate.accumulate("Longitude", longitude);
		locate.accumulate("Latitude", latitude);
		locate.accumulate("Bearing", loc.getBearing());
		locate.accumulate("Altitude", loc.getAltitude());
		locate.accumulate("Accuracy", loc.getAccuracy());
		locate.accumulate("Address", myAddress);
		
		object.accumulate("Time", time);
		object.accumulate("Date", date);
		object.accumulate("Location", locate.toString());
		object.accumulate("Temperature", temperature);
		

		location = object.toString();
		value.setText(location);

		//location = object.toString();
		//value.setText(location);

		
	} catch (JSONException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
	}
	
}

public void getAddress(double longi, double lati){
	
	 Geocoder geocoder = new Geocoder(this, Locale.ENGLISH);

       try {
  List<Address> addresses = geocoder.getFromLocation(lati, longi, 1);
 
  if(addresses != null) {
   Address returnedAddress = addresses.get(0);
   StringBuilder strReturnedAddress = new StringBuilder("Address:\n");
   for(int i=0; i<returnedAddress.getMaxAddressLineIndex(); i++) {
    strReturnedAddress.append(returnedAddress.getAddressLine(i)).append("\n");
   }
   myAddress = strReturnedAddress.toString();
  }
  else{
   myAddress = "No Address returned!";
  }
 } catch (IOException e) {
  // TODO Auto-generated catch block
  e.printStackTrace();
  myAddress = "Canont get Address!";
 }
}

public void initializeVariables(){
	
	pageCount = 1;
	username = "p11111111";
	time = (new Random().nextLong())+"";
    date = "2014-10-10";
	temperature = "23 C";
	location = (new Random().nextLong())+","+(new Random().nextLong());
	
	infoLayout = (LinearLayout)findViewById(R.id.hanging_infoLayout);
	tv_ioName = (TextView)findViewById(R.id.hanging_tv_io_name);
	ioName = (EditText)findViewById(R.id.hanging_io_name);
	tv_ioSurname = (TextView)findViewById(R.id.hanging_tv_io_surname);
	ioSurname = (EditText)findViewById(R.id.hanging_io_surname);
	tv_ioRank = (TextView)findViewById(R.id.hanging_tv_io_rank);
	ioRank = (EditText)findViewById(R.id.hanging_io_rank);
	tv_ioCellNo = (TextView)findViewById(R.id.hanging_tv_io_cell);
	ioCellNo = (EditText)findViewById(R.id.hanging_io_cell);
	
	tv_foosName = (TextView)findViewById(R.id.hanging_tv_foos_name);
	foosName = (EditText)findViewById(R.id.hanging_foos_name);
	tv_foosSurname = (TextView)findViewById(R.id.hanging_tv_foos_surname);
	foosSurname = (EditText)findViewById(R.id.hanging_foos_surname);
	tv_foosRank = (TextView)findViewById(R.id.hanging_tv_foos_rank);
	foosRank = (EditText)findViewById(R.id.hanging_foos_rank);
	
	tv_io = (TextView)findViewById(R.id.hanging_tv_io);
	tv_foos = (TextView)findViewById(R.id.hanging_tv_foos);
	
	
	demographicsLayout = (LinearLayout)findViewById(R.id.hanging_demographicLayout);
	tv_victimInfo = (TextView)findViewById(R.id.hanging_tv_victimInfo);
	tv_victimRace = (TextView)findViewById(R.id.hanging_tv_victimRace);
	tv_victimGender = (TextView)findViewById(R.id.hanging_tv_victimGender);
	tv_victimName = (TextView)findViewById(R.id.hanging_tv_victim_name);
	victimName = (EditText)findViewById(R.id.hanging_victim_name);
	tv_victimSurname = (TextView)findViewById(R.id.hanging_tv_victim_surname);
	victimSurname = (EditText)findViewById(R.id.hanging_victim_surname);
	tv_victimIDNo = (TextView)findViewById(R.id.hanging_tv_victim_id);
	victimIDNo = (EditText)findViewById(R.id.hanging_victim_id);
	
	rgbMale = (RadioButton)findViewById(R.id.hanging_rgbMale);
	rgbFemale = (RadioButton)findViewById(R.id.hanging_rgbFemale);
	rgbUnknownGender = (RadioButton)findViewById(R.id.hanging_rgbUnknownGender);
	
	rgbAsian = (RadioButton)findViewById(R.id.hanging_rgbAsian);
	rgbBlack = (RadioButton)findViewById(R.id.hanging_rgbBlack);
	rgbColoured = (RadioButton)findViewById(R.id.hanging_rgbColoured);
	rgbWhite = (RadioButton)findViewById(R.id.hanging_rgbWhite);
	rgbUnknownRace = (RadioButton)findViewById(R.id.hanging_rgbUnknownRace);
	
	theBodyLayout = (LinearLayout)findViewById(R.id.hanging_theBodyLayout);
	theBody = (TextView)findViewById(R.id.hanging_tv_the_body);
	tv_bodyDecomposed = (TextView)findViewById(R.id.hanging_tv_bodyDecomposed);
	bodyDecomposed = (Spinner)findViewById(R.id.hanging_bodyDecomposed);
	tv_medicalIntervention = (TextView)findViewById(R.id.hanging_tv_medicalIntervention);
	medicalIntervention = (Spinner)findViewById(R.id.hanging_medicalIntervention);
	tv_whoFoundVictimBody = (TextView)findViewById(R.id.hanging_tv_whoFoundVictimBody);
	whoFoundVictimBody = (EditText)findViewById(R.id.hanging_whoFoundVictimBody);
	tv_closeToWater = (TextView)findViewById(R.id.hanging_tv_closeToWater);
	closeToWater = (Spinner)findViewById(R.id.hanging_closeToWater);
	tv_rapeHomicide = (TextView)findViewById(R.id.hanging_tv_rapeHomicide);
	rapeHomicide = (Spinner)findViewById(R.id.hanging_rapeHomicide);
	tv_suicideSuspected = (TextView)findViewById(R.id.hanging_tv_suicideSuspected);
	suicideSuspected = (Spinner)findViewById(R.id.hanging_suicideSuspected);
	tv_previousAttempts = (TextView)findViewById(R.id.hanging_tv_previousAttempts);
	previousAttempts = (Spinner)findViewById(R.id.hanging_previousAttempts);
	tv_howManyAttempts = (TextView)findViewById(R.id.hanging_tv_howManyAttempts);
	howManyAttempts = (EditText)findViewById(R.id.hanging_howManyAttempts);
	
	sceneOfInjuryLayout = (LinearLayout)findViewById(R.id.hanging_sceneOfInjuryLayout);
	sceneOfInjury = (TextView)findViewById(R.id.hanging_sceneOfInjury);
	tv_sceneIOType = (TextView)findViewById(R.id.hanging_tv_sceneIOType);
	sceneIOType = (Spinner)findViewById(R.id.hanging_sceneIOType);
	tv_whereInside = (TextView)findViewById(R.id.hanging_tv_whereInside);
	sceneIType = (Spinner)findViewById(R.id.hanging_sceneIType);
	tv_sceneITypeOther = (TextView)findViewById(R.id.hanging_tv_sceneITypeOther);
	sceneITypeOther = (EditText)findViewById(R.id.hanging_sceneITypeOther);
	tv_doorLocked = (TextView)findViewById(R.id.hanging_tv_doorLocked);
	doorLocked = (Spinner)findViewById(R.id.hanging_doorLocked);
	tv_windowsClosed = (TextView)findViewById(R.id.hanging_tv_windowsClosed);
	windowsClosed = (Spinner)findViewById(R.id.hanging_windowsClosed);
	tv_windowsBroken = (TextView)findViewById(R.id.hanging_tv_windowsBroken);
	windowsBroken = (Spinner)findViewById(R.id.hanging_windowsBroken);
	tv_victimAlone = (TextView)findViewById(R.id.hanging_tv_victimAlone);
	victimAlone = (Spinner)findViewById(R.id.hanging_victimAlone);
	tv_peopleWithVictim = (TextView)findViewById(R.id.hanging_tv_peopleWithVictim);
	peopleWithVictim = (EditText)findViewById(R.id.hanging_peopleWithVictim);
	tv_sceneOType = (TextView)findViewById(R.id.hanging_tv_sceneOType);
	sceneOType = (Spinner)findViewById(R.id.hanging_sceneOType);
	tv_sceneOTypeOther = (TextView)findViewById(R.id.hanging_tv_sceneOTypeOther);
	sceneOTypeOther = (EditText)findViewById(R.id.hanging_sceneOTypeOther);
	
	sceneLookLayout = (LinearLayout)findViewById(R.id.hanging_sceneLookLayout);
	sceneLook = (TextView)findViewById(R.id.hanging_sceneLook);
	tv_signsOfStruggle = (TextView)findViewById(R.id.hanging_tv_signsOfStruggle);
	signsOfStruggle = (Spinner)findViewById(R.id.hanging_signsOfStruggle);
	tv_alcoholBottleAround = (TextView)findViewById(R.id.hanging_tv_alcoholBottleAround);
	alcoholBottleAround = (Spinner)findViewById(R.id.hanging_alcoholBottleAround);
	tv_drugParaphernalia = (TextView)findViewById(R.id.hanging_tv_drugParaphernalia);
	drugParaphernalia = (Spinner)findViewById(R.id.hanging_drugParaphernalia);
	
	theSceneLayout = (LinearLayout)findViewById(R.id.hanging_theSceneLayout);
	theScene = (TextView)findViewById(R.id.hanging_theScene);
	tv_autoeroticAsphyxia = (TextView)findViewById(R.id.hanging_tv_autoeroticAsphyxia);
	autoeroticAsphyxia = (Spinner)findViewById(R.id.hanging_autoeroticAsphyxia);
	tv_partialHanging = (TextView)findViewById(R.id.hanging_tv_partialHanging);
	partialHanging = (Spinner)findViewById(R.id.hanging_partialHanging);
	tv_partialHangingOther = (TextView)findViewById(R.id.hanging_tv_partialHangingOther);
	partialHangingOther = (EditText)findViewById(R.id.hanging_partialHangingOther);
	tv_completeHanging = (TextView)findViewById(R.id.hanging_tv_completeHanging);
	completeHanging = (Spinner)findViewById(R.id.hanging_completeHanging);
	tv_ligatureAroundNeck = (TextView)findViewById(R.id.hanging_tv_ligatureAroundNeck);
	ligatureAroundNeck = (Spinner)findViewById(R.id.hanging_ligatureAroundNeck);
	tv_whoRemovedligature = (TextView)findViewById(R.id.hanging_tv_whoRemovedligature);
	whoRemovedligature = (EditText)findViewById(R.id.hanging_whoRemovedligature);
	tv_ligatureType = (TextView)findViewById(R.id.hanging_tv_ligatureType);
	ligatureType = (Spinner)findViewById(R.id.hanging_ligatureType);
	tv_ligatureTypeOther = (TextView)findViewById(R.id.hanging_tv_ligatureTypeOther);
	ligatureTypeOther = (EditText)findViewById(R.id.hanging_ligatureTypeOther);
	tv_strangulationSuspected = (TextView)findViewById(R.id.hanging_tv_strangulationSuspected);
	strangulationSuspected = (Spinner)findViewById(R.id.hanging_strangulationSuspected);
	tv_smotheringSuspected = (TextView)findViewById(R.id.hanging_tv_smotheringSuspected);
	smotheringSuspected = (Spinner)findViewById(R.id.hanging_smotheringSuspected);
	tv_chockingSuspected = (TextView)findViewById(R.id.hanging_tv_chockingSuspected);
	chockingSuspected = (Spinner)findViewById(R.id.hanging_chockingSuspected);
	tv_suicideNoteFound = (TextView)findViewById(R.id.hanging_tv_suicideNoteFound);
	suicideNoteFound = (Spinner)findViewById(R.id.hanging_suicideNoteFound);
	tv_generalHistory = (TextView)findViewById(R.id.hanging_tv_generalHistory);
	generalHistory = (EditText)findViewById(R.id.hanging_generalHistory);
	
	galleryLayout = (LinearLayout)findViewById(R.id.hanging_galleryLayout);
	response = (TextView)findViewById(R.id.hanging_tv_response);
	nextButton = (Button)findViewById(R.id.hanging_nextButton);
	doneButton = (Button)findViewById(R.id.hanging_doneButton);
	logoutButton = (Button)findViewById(R.id.hanging_logoutButton);
	
	value = (TextView) findViewById(R.id.value);
}
	
	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
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
		        pairs.add(new BasicNameValuePair("category","hanging"));
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
		
		ligatureType.setOnItemSelectedListener(new OnItemSelectedListener() {

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
							tv_ligatureTypeOther.setVisibility(VISIBLE);
							ligatureTypeOther.setVisibility(VISIBLE);
						}else{
							tv_ligatureTypeOther.setVisibility(GONE);
							ligatureTypeOther.setVisibility(GONE);
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
		
		ligatureAroundNeck.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> av, View view, int index,
					long arg3) {
				// TODO Auto-generated method stub
				try{
					TextView s = (TextView)view;
					if(s != null)
					{
						String item = (String)s.getText().toString();
						if(item.toLowerCase().equals("no"))
						{
							tv_whoRemovedligature.setVisibility(VISIBLE);
							whoRemovedligature.setVisibility(VISIBLE);
						}else{
							tv_whoRemovedligature.setVisibility(GONE);
							whoRemovedligature.setVisibility(GONE);
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
		
		partialHanging.setOnItemSelectedListener(new OnItemSelectedListener() {

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
							tv_partialHangingOther.setVisibility(VISIBLE);
							partialHangingOther.setVisibility(VISIBLE);
						}else{
							tv_partialHangingOther.setVisibility(GONE);
							partialHangingOther.setVisibility(GONE);
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
		
	}
	private void showHideButtons(){
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
				tv_partialHangingOther.setVisibility(GONE);
				partialHangingOther.setVisibility(GONE);
				tv_ligatureTypeOther.setVisibility(GONE);
				ligatureTypeOther.setVisibility(GONE);
				tv_whoRemovedligature.setVisibility(GONE);
				whoRemovedligature.setVisibility(GONE);
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
					}catch(Exception ex){}
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
						
					}catch(Exception ex){}
					break;
				case 5:
					return true;
				case 6:
					try{
						String lan = (String)ligatureAroundNeck.getSelectedItem();
						String lt = (String)ligatureType.getSelectedItem();
						String ph = (String)partialHanging.getSelectedItem();
						
						
						if(!generalHistory.getText().toString().equals("")){
							if(lan.toLowerCase().equals("no") && !whoRemovedligature.getText().toString().equals("")
									&& !lt.toLowerCase().equals("other") && !ph.toLowerCase().equals("other"))
							{
								
								return true;
							}else if(lan.toLowerCase().equals("no") && !whoRemovedligature.getText().toString().equals("")
									&& !lt.toLowerCase().equals("other") && ph.toLowerCase().equals("other"))
							{
								
								if(!partialHangingOther.getText().toString().equals("")){
										return true;
								}
							}else if(lan.toLowerCase().equals("no") && !whoRemovedligature.getText().toString().equals("")
									&& lt.toLowerCase().equals("other") && !ph.toLowerCase().equals("other"))
							{
								
								if(!ligatureTypeOther.getText().toString().equals("")){
									return true;
								}
							}else if(lan.toLowerCase().equals("no") && !whoRemovedligature.getText().toString().equals("")
									&& lt.toLowerCase().equals("other") && ph.toLowerCase().equals("other"))
							{
								
								if(!ligatureTypeOther.getText().toString().equals("") && !partialHangingOther.getText().toString().equals("")){
									return true;
								}
							}else if(lan.toLowerCase().equals("yes")
									&& lt.toLowerCase().equals("other") && ph.toLowerCase().equals("other"))
							{
								
								if(!ligatureTypeOther.getText().toString().equals("") && !partialHangingOther.getText().toString().equals("")){
									return true;
								}
							}else if(lan.toLowerCase().equals("yes")
									&& !lt.toLowerCase().equals("other") && ph.toLowerCase().equals("other"))
							{
								
								if(!partialHangingOther.getText().toString().equals("")){
									return true;
								}
							}else if(lan.toLowerCase().equals("yes")
									&& lt.toLowerCase().equals("other") && !ph.toLowerCase().equals("other"))
							{
								
								if(!ligatureTypeOther.getText().toString().equals("")){
									return true;
								}
							}else if(lan.toLowerCase().equals("yes")
									&& !lt.toLowerCase().equals("other") && !ph.toLowerCase().equals("other"))
							{
								
								return true;
							}
							
						}
					}catch(Exception ex){
						ex.printStackTrace();
					}
					break;
				case 7:
					return true;
					
			}
		}catch(Exception e){e.printStackTrace();}
		return false;
	}
	
	private List<NameValuePair> getPostData(){
		try{
			List<NameValuePair> pairs = new ArrayList<NameValuePair>();  
	
	        pairs.add(new BasicNameValuePair("rquest","addCase"));
	        pairs.add(new BasicNameValuePair("category","hanging"));
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
	        
	        info.accumulate("hangingIOType",getIOType() );
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
	        info.accumulate("autoeroticAsphyxia", (String)autoeroticAsphyxia.getSelectedItem());
	        info.accumulate("partialHangingType", getPartialHangingType());
	        info.accumulate("completeHanging", (String)completeHanging.getSelectedItem());
	        info.accumulate("ligatureAroundNeck", (String)ligatureAroundNeck.getSelectedItem());
	        info.accumulate("ligatureType", getLigatureType());
	        info.accumulate("whoRemovedLigature", whoRemovedligature.getText().toString());
	        
	        
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
	
	private int getAttempts(){
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
	
	private void saveDataOnAction() throws Exception{
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
        
        info.accumulate("hangingIOType",getIOType() );
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
        info.accumulate("autoeroticAsphyxia", (String)autoeroticAsphyxia.getSelectedItem());
        info.accumulate("partialHangingType", getPartialHangingType());
        info.accumulate("completeHanging", (String)completeHanging.getSelectedItem());
        info.accumulate("ligatureAroundNeck", (String)ligatureAroundNeck.getSelectedItem());
        info.accumulate("ligatureType", getLigatureType());
        info.accumulate("whoRemovedLigature", whoRemovedligature.getText().toString());
                
        
        array.put(info);
        obj.accumulate("object", array);
        currentDataSaved = obj;
        
	}
	
	
	private void saveData(JSONObject data) throws Exception{
		
		System.out.println("SAVED: "+data.toString());
		
	}
	
	private void resendData() throws Exception{
		
	}
	
	private String getLigatureType(){
		try{
			
			String item = (String)ligatureType.getSelectedItem();
			if(item.toLowerCase().equals("other"))
			{
				return ligatureTypeOther.getText().toString();
			}else{
				
				return item;
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		return "";
	}
	private String getPeopleWithVictim(){
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
	
	private String getPartialHangingType(){
		try{
			
			String item = (String)partialHanging.getSelectedItem();
			if(item.toLowerCase().equals("other"))
			{
				return partialHangingOther.getText().toString();
			}else{
				
				return item;
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		return "";
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
            	System.out.println(line);
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
				e.printStackTrace();
			}
		}
	
    }
}
