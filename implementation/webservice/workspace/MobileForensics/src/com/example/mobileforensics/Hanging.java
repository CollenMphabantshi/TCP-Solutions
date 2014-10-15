package com.example.mobileforensics;

import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
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


import com.example.mobileforensics.Blunt.Read;
import com.example.mobileforensics.models.Weather;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.GoogleMap.OnMyLocationChangeListener;


import android.app.Activity;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.BitmapFactory;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.MediaStore;
import android.text.format.Time;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.GridLayout;
import android.widget.ImageView;
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
	private TextView tv_victimAge;
	private EditText victimAge;
	
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

	private GridLayout theBodyLayout;
	private TextView theBody;
	private TextView tv_bodyDecomposed;
	private RadioButton bodyDecomposedYes;
	private RadioButton bodyDecomposedNo;
	private TextView tv_medicalIntervention;
	private RadioButton medicalInterventionYes;
	private RadioButton medicalInterventionNo;
	private TextView tv_whoFoundVictimBody;
	private EditText whoFoundVictimBody;
	private TextView tv_closeToWater;
	private RadioButton closeToWaterYes;
	private RadioButton closeToWaterNo;
	private TextView tv_rapeHomicide;
	private RadioButton rapeHomicideYes;
	private RadioButton rapeHomicideNo;
	private TextView tv_suicideSuspected;
	private RadioButton suicideSuspectedYes;
	private RadioButton suicideSuspectedNo;
	private TextView tv_previousAttempts;
	private RadioButton previousAttemptsYes;
	private RadioButton previousAttemptsNo;
	private TextView tv_howManyAttempts;
	private EditText howManyAttempts;
	
	private GridLayout theSceneOfInjuryLayout;
	private TextView sceneOfInjury;
	private TextView tv_sceneIOType;
	private RadioButton sceneIOTypeInside;
	private RadioButton sceneIOTypeOutside;
	private TextView tv_whereInside;
	private Spinner sceneIType;
	private TextView tv_sceneITypeOther;
	private EditText sceneITypeOther;
	private TextView tv_doorLocked;
	private RadioButton doorLockedYes;
	private RadioButton doorLockedNo;
	private TextView tv_windowsClosed;
	private RadioButton windowsClosedYes;
	private RadioButton windowsClosedNo;
	private TextView tv_windowsBroken;
	private RadioButton windowsBrokenYes;
	private RadioButton windowsBrokenNo;
	private TextView tv_victimAlone;
	private RadioButton victimAloneYes;
	private RadioButton victimAloneNo;
	private TextView tv_peopleWithVictim;
	private EditText peopleWithVictim;
	private TextView tv_sceneOType;
	private Spinner sceneOType;
	private TextView tv_sceneOTypeOther;
	private EditText sceneOTypeOther;
	
	private GridLayout theSceneLookLayout;
	private TextView sceneLook;
	private TextView tv_signsOfStruggle;
	private RadioButton signsOfStruggleYes;
	private RadioButton signsOfStruggleNo;
	private TextView tv_alcoholBottleAround;
	private RadioButton alcoholBottleAroundYes;
	private RadioButton alcoholBottleAroundNo;
	private TextView tv_drugParaphernalia;
	private RadioButton drugParaphernaliaYes;
	private RadioButton drugParaphernaliaNo;
	
	private GridLayout theSceneLayout;
	private TextView theScene;
	private TextView tv_autoeroticAsphyxia;
	private RadioButton autoeroticAsphyxiaYes;
	private RadioButton autoeroticAsphyxiaNo;
	private TextView tv_partialHanging;
	private RadioButton partialHangingYes;
	private RadioButton partialHangingNo;
	private TextView tv_partialHangingType;
	private Spinner partialHanging;
	private TextView tv_partialHangingOther;
	private EditText partialHangingOther;
	private TextView tv_completeHanging;
	private RadioButton completeHangingFG;
	private RadioButton completeHangingFS;
	private TextView tv_ligatureAroundNeck;
	private RadioButton ligatureAroundNeckYes;
	private RadioButton ligatureAroundNeckNo;
	private TextView tv_whoRemovedligature;
	private EditText whoRemovedligature;
	private TextView tv_ligatureType;
	private Spinner ligatureType;
	private TextView tv_ligatureTypeOther;
	private EditText ligatureTypeOther;
	private TextView tv_strangulationSuspected;
	private RadioButton strangulationSuspectedYes;
	private RadioButton strangulationSuspectedNo;
	private TextView tv_smotheringSuspected;
	private RadioButton smotheringSuspectedYes;
	private RadioButton smotheringSuspectedNo;
	private TextView tv_chockingSuspected;
	private RadioButton chockingSuspectedYes;
	private RadioButton chockingSuspectedNo;
	private TextView tv_suicideNoteFound;
	private RadioButton suicideNoteFoundYes;
	private RadioButton suicideNoteFoundNo;
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
	
	
	//upload image parameters still to be arranged
		TextView messageText;
	    Button uploadButton,selectImages,buttonLoadImage;
	    ImageView imageView0,imageView1,imageView2,imageView3,imageView4,imageView5,imageView6,imageView7,imageView8;
	    int serverResponseCode = 0;
	    ProgressDialog dialog = null;
	    Uri currImageURI;
	    String  upLoadServerUri = "http://forensicsapp.co.za/webapp/images/images.php";
	    private static int RESULT_LOAD_IMAGE = 1;
	    int count = 0;
	    ArrayList<String> uploadFileName = new ArrayList<String>();
	    String filename ;
	    
	    //weather section
	    private String WeatherInfo="";
	    private TextView weatherInfo;
	    private Encryption enc;
		
	    
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		
		try{
			setContentView(R.layout.hanging);
			status = GooglePlayServicesUtil.isGooglePlayServicesAvailable(getBaseContext());
			
			initializeVariables();
			initialize();
			CheckRadioButtons();
			setOnClickEvents();
			showHideButtons();
		}catch(Exception e){
			e.printStackTrace();
		}
	}
	
	public void initialize(){
		try{
			if( status != ConnectionResult.SUCCESS){
				int requestCode = 10;
				Dialog dialog = GooglePlayServicesUtil.getErrorDialog(status, this, requestCode);
				dialog.show();
			}else{
				map = ((MapFragment) getFragmentManager().findFragmentById(R.id.fragId)).getMap();
				map.setMyLocationEnabled(true);
				map.setOnMyLocationChangeListener(this);
				
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		
	}

@Override
public void onMyLocationChange(Location loc) {
	// TODO Auto-generated method stub
	
	
    
    try {
    	locate = new JSONObject();
		JSONObject object = new JSONObject();
		//get geolactions, time and date
		longitude = loc.getLongitude();
		latitude = loc.getLatitude();
		Calendar c = Calendar.getInstance();
        SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        String formattedDate = df.format(c.getTime());
        time = formattedDate.substring(11);
        date = formattedDate.substring(0, formattedDate.length()-9);
        getAddress(longitude,latitude);
		locate.accumulate("Longitude", longitude);
		locate.accumulate("Latitude", latitude);
		locate.accumulate("Bearing", loc.getBearing());
		locate.accumulate("Altitude", loc.getAltitude());
		locate.accumulate("Accuracy", loc.getAccuracy());
		locate.accumulate("Address", myAddress);
		
		object.accumulate("Time", time);
		object.accumulate("Date", date);
		object.accumulate("Location", locate.toString());
		
		location = object.toString();
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
	
	
	try{
		enc = new Encryption();
		username = getIntent().getExtras().getString("USERNAME");
	}catch(Exception e){e.printStackTrace();}
	
	try{
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
	victimAge = (EditText)findViewById(R.id.hanging_victim_age);
	
	rgbMale = (RadioButton)findViewById(R.id.hanging_rgbMale);
	rgbFemale = (RadioButton)findViewById(R.id.hanging_rgbFemale);
	rgbUnknownGender = (RadioButton)findViewById(R.id.hanging_rgbUnknownGender);
	
	rgbAsian = (RadioButton)findViewById(R.id.hanging_rgbAsian);
	rgbBlack = (RadioButton)findViewById(R.id.hanging_rgbBlack);
	rgbColoured = (RadioButton)findViewById(R.id.hanging_rgbColoured);
	rgbWhite = (RadioButton)findViewById(R.id.hanging_rgbWhite);
	rgbUnknownRace = (RadioButton)findViewById(R.id.hanging_rgbUnknownRace);
	
	theBodyLayout = (GridLayout)findViewById(R.id.hanging_theBodyLayout);
	theBody = (TextView)findViewById(R.id.hanging_tv_the_body);
	tv_bodyDecomposed = (TextView)findViewById(R.id.hanging_tv_bodyDecomposed);
	bodyDecomposedYes = (RadioButton)findViewById(R.id.hanging_bodyDecomposedYes);
	bodyDecomposedNo = (RadioButton)findViewById(R.id.hanging_bodyDecomposedNo);
	tv_medicalIntervention = (TextView)findViewById(R.id.hanging_tv_medicalIntervention);
	medicalInterventionYes = (RadioButton)findViewById(R.id.hanging_medicalInterventionYes);
	medicalInterventionNo = (RadioButton)findViewById(R.id.hanging_medicalInterventionNo);
	tv_whoFoundVictimBody = (TextView)findViewById(R.id.hanging_tv_whoFoundVictimBody);
	whoFoundVictimBody = (EditText)findViewById(R.id.hanging_whoFoundVictimBody);
	tv_closeToWater = (TextView)findViewById(R.id.hanging_tv_closeToWater);
	closeToWaterYes = (RadioButton)findViewById(R.id.hanging_closeToWaterYes);
	closeToWaterNo = (RadioButton)findViewById(R.id.hanging_closeToWaterNo);
	tv_rapeHomicide = (TextView)findViewById(R.id.hanging_tv_rapeHomicide);
	rapeHomicideYes = (RadioButton)findViewById(R.id.hanging_rapeHomicideYes);
	rapeHomicideNo = (RadioButton)findViewById(R.id.hanging_rapeHomicideNo);
	tv_suicideSuspected = (TextView)findViewById(R.id.hanging_tv_suicideSuspected);
	suicideSuspectedYes = (RadioButton)findViewById(R.id.hanging_suicideSuspectedYes);
	suicideSuspectedNo = (RadioButton)findViewById(R.id.hanging_suicideSuspectedNo);
	tv_previousAttempts = (TextView)findViewById(R.id.hanging_tv_previousAttempts);
	previousAttemptsYes = (RadioButton)findViewById(R.id.hanging_previousAttemptsYes);
	previousAttemptsNo = (RadioButton)findViewById(R.id.hanging_previousAttemptsNo);
	tv_howManyAttempts = (TextView)findViewById(R.id.hanging_tv_howManyAttempts);
	howManyAttempts = (EditText)findViewById(R.id.hanging_howManyAttempts);
	
	theSceneOfInjuryLayout = (GridLayout)findViewById(R.id.hanging_sceneOfInjuryLayout);
	sceneOfInjury = (TextView)findViewById(R.id.hanging_sceneOfInjury);
	tv_sceneIOType = (TextView)findViewById(R.id.hanging_tv_sceneIOType);
	sceneIOTypeInside = (RadioButton)findViewById(R.id.hanging_SceneIOTypeInside);
	sceneIOTypeOutside = (RadioButton)findViewById(R.id.hanging_SceneIOTypeOutside);
	tv_whereInside = (TextView)findViewById(R.id.hanging_tv_whereInside);
	sceneIType = (Spinner)findViewById(R.id.hanging_sceneIType);
	tv_sceneITypeOther = (TextView)findViewById(R.id.hanging_tv_sceneITypeOther);
	sceneITypeOther = (EditText)findViewById(R.id.hanging_sceneITypeOther);
	tv_doorLocked = (TextView)findViewById(R.id.hanging_tv_doorLocked);
	doorLockedYes = (RadioButton)findViewById(R.id.hanging_DoorLockedYes);
	doorLockedNo = (RadioButton)findViewById(R.id.hanging_DoorLockedNo);
	tv_windowsClosed = (TextView)findViewById(R.id.hanging_tv_windowsClosed);
	windowsClosedYes = (RadioButton)findViewById(R.id.hanging_WindowsClosedYes);
	windowsClosedNo = (RadioButton)findViewById(R.id.hanging_WindowsClosedNo);
	tv_windowsBroken = (TextView)findViewById(R.id.hanging_tv_windowsBroken);
	windowsBrokenYes = (RadioButton)findViewById(R.id.hanging_WindowsBrokenYes);
	windowsBrokenNo = (RadioButton)findViewById(R.id.hanging_WindowsBrokenNo);
	tv_victimAlone = (TextView)findViewById(R.id.hanging_tv_victimAlone);
	victimAloneYes = (RadioButton)findViewById(R.id.hanging_VictimAloneYes);
	victimAloneNo = (RadioButton)findViewById(R.id.hanging_VictimAloneNo);
	tv_peopleWithVictim = (TextView)findViewById(R.id.hanging_tv_peopleWithVictim);
	peopleWithVictim = (EditText)findViewById(R.id.hanging_peopleWithVictim);
	tv_sceneOType = (TextView)findViewById(R.id.hanging_tv_sceneOType);
	sceneOType = (Spinner)findViewById(R.id.hanging_sceneOType);
	tv_sceneOTypeOther = (TextView)findViewById(R.id.hanging_tv_sceneOTypeOther);
	sceneOTypeOther = (EditText)findViewById(R.id.hanging_sceneOTypeOther);
	
	theSceneLookLayout = (GridLayout)findViewById(R.id.hanging_sceneLookLayout);
	sceneLook = (TextView)findViewById(R.id.hanging_sceneLook);
	tv_signsOfStruggle = (TextView)findViewById(R.id.hanging_tv_signsOfStruggle);
	signsOfStruggleYes = (RadioButton)findViewById(R.id.hanging_SignsOfStruggleYes);
	signsOfStruggleNo = (RadioButton)findViewById(R.id.hanging_SignsOfStruggleNo);
	tv_alcoholBottleAround = (TextView)findViewById(R.id.hanging_tv_alcoholBottleAround);
	alcoholBottleAroundYes = (RadioButton)findViewById(R.id.hanging_AlcoholBottleAroundYes);
	alcoholBottleAroundNo = (RadioButton)findViewById(R.id.hanging_AlcoholBottleAroundNo);
	tv_drugParaphernalia = (TextView)findViewById(R.id.hanging_tv_drugParaphernalia);
	drugParaphernaliaYes = (RadioButton)findViewById(R.id.hanging_DrugParaphernaliaYes);
	drugParaphernaliaNo = (RadioButton)findViewById(R.id.hanging_DrugParaphernaliaNo);
	
	theSceneLayout = (GridLayout)findViewById(R.id.hanging_theSceneLayout);
	theScene = (TextView)findViewById(R.id.hanging_theScene);
	tv_autoeroticAsphyxia = (TextView)findViewById(R.id.hanging_tv_autoeroticAsphyxia);
	autoeroticAsphyxiaYes = (RadioButton)findViewById(R.id.hanging_autoeroticAsphyxiaYes);
	autoeroticAsphyxiaNo = (RadioButton)findViewById(R.id.hanging_autoeroticAsphyxiaNo);
	tv_partialHanging = (TextView)findViewById(R.id.hanging_tv_partialHanging);
	partialHangingYes = (RadioButton)findViewById(R.id.hanging_partialHangingYes);
	partialHangingNo = (RadioButton)findViewById(R.id.hanging_partialHangingNo);
	tv_partialHangingType = (TextView)findViewById(R.id.hanging_tv_partialHangingType);
	partialHanging = (Spinner)findViewById(R.id.hanging_partialHanging);
	tv_partialHangingOther = (TextView)findViewById(R.id.hanging_tv_partialHangingOther);
	partialHangingOther = (EditText)findViewById(R.id.hanging_partialHangingOther);
	tv_completeHanging = (TextView)findViewById(R.id.hanging_tv_completeHanging);
	completeHangingFG = (RadioButton)findViewById(R.id.hanging_completeHangingFG);
	completeHangingFS = (RadioButton)findViewById(R.id.hanging_completeHangingFS);
	tv_ligatureAroundNeck = (TextView)findViewById(R.id.hanging_tv_ligatureAroundNeck);
	ligatureAroundNeckYes = (RadioButton)findViewById(R.id.hanging_ligatureAroundNeckYes);
	ligatureAroundNeckNo = (RadioButton)findViewById(R.id.hanging_ligatureAroundNeckNo);
	tv_whoRemovedligature = (TextView)findViewById(R.id.hanging_tv_whoRemovedligature);
	whoRemovedligature = (EditText)findViewById(R.id.hanging_whoRemovedligature);
	tv_ligatureType = (TextView)findViewById(R.id.hanging_tv_ligatureType);
	ligatureType = (Spinner)findViewById(R.id.hanging_ligatureType);
	tv_ligatureTypeOther = (TextView)findViewById(R.id.hanging_tv_ligatureTypeOther);
	ligatureTypeOther = (EditText)findViewById(R.id.hanging_ligatureTypeOther);
	tv_strangulationSuspected = (TextView)findViewById(R.id.hanging_tv_strangulationSuspected);
	strangulationSuspectedYes = (RadioButton)findViewById(R.id.hanging_StrangulationSuspectedYes);
	strangulationSuspectedNo = (RadioButton)findViewById(R.id.hanging_StrangulationSuspectedNo);
	tv_smotheringSuspected = (TextView)findViewById(R.id.hanging_tv_smotheringSuspected);
	smotheringSuspectedYes = (RadioButton)findViewById(R.id.hanging_SmotheringSuspectedYes);
	smotheringSuspectedNo = (RadioButton)findViewById(R.id.hanging_SmotheringSuspectedNo);
	tv_chockingSuspected = (TextView)findViewById(R.id.hanging_tv_chockingSuspected);
	chockingSuspectedYes = (RadioButton)findViewById(R.id.hanging_ChockingSuspectedYes);
	chockingSuspectedNo = (RadioButton)findViewById(R.id.hanging_ChockingSuspectedNo);
	tv_suicideNoteFound = (TextView)findViewById(R.id.hanging_tv_suicideNoteFound);
	suicideNoteFoundYes = (RadioButton)findViewById(R.id.hanging_SuicideNoteFoundYes);
	tv_generalHistory = (TextView)findViewById(R.id.hanging_tv_generalHistory);
	generalHistory = (EditText)findViewById(R.id.hanging_generalHistory);
	
	galleryLayout = (LinearLayout)findViewById(R.id.hanging_galleryLayout);
	response = (TextView)findViewById(R.id.hanging_tv_response);
	
	doneButton = (Button)findViewById(R.id.hanging_doneButton);
	logoutButton = (Button)findViewById(R.id.hanging_logoutButton);
	
	//next = (Button) findViewById(R.id.nextButton);
	value = (TextView) findViewById(R.id.value);
	
	//upload pictures part
		//uploadButton = (Button)findViewById(R.id.uploadButton);
       messageText  = (TextView)findViewById(R.id.messageText);
       buttonLoadImage = (Button) findViewById(R.id.buttonLoadPicture);
       imageView0 = (ImageView) findViewById(R.id.imgView0);
       imageView1 = (ImageView) findViewById(R.id.imgView1);
       imageView2 = (ImageView) findViewById(R.id.imgView2);
       imageView3 = (ImageView) findViewById(R.id.imgView3);
       imageView4 = (ImageView) findViewById(R.id.imgView4);
       imageView5 = (ImageView) findViewById(R.id.imgView5);
       imageView6 = (ImageView) findViewById(R.id.imgView6);
       imageView7 = (ImageView) findViewById(R.id.imgView7);
       imageView8 = (ImageView) findViewById(R.id.imgView8);
       
       
       // weather section
       weatherInfo = (TextView) findViewById(R.id.bluntWeatherInfo);
	}catch(Exception e){
		e.printStackTrace();
	}
}
	
	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
	}
	private void setOnClickEvents(){
		
doneButton.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View view) {
				// TODO Auto-generated method stub
				try{
					//submit data to the server
					List<NameValuePair> postdata = getPostData();
					if(postdata != null)
					{
						try{
							
							if(ValidateFields())
							{
								new Read().execute(postdata);
								
								dialog = ProgressDialog.show(Hanging.this, "", "Uploading file...", true);
				                 
				                new Thread(new Runnable() {
				                        public void run() {
				                             runOnUiThread(new Runnable() {
				                                    public void run() {
				                                        messageText.setText("uploading started.....");
				                                    }
				                                });                      
				                             for(int i=0; i < uploadFileName.size(); i++){
				                            	 filename = uploadFileName.get(i);
				                            	 uploadFile( filename );
				                            	 
				                             }                   
				                        }
				                      }).start(); 
				                doneButton.setVisibility(GONE);
								logoutButton.setVisibility(VISIBLE);
								Toast.makeText(Hanging.this, "form successfully filled", Toast.LENGTH_LONG).show();
							}else{
								
							}
						}catch(Exception e){
							e.printStackTrace();
						}
						
					}
						
					
					//nextButton.setVisibility(GONE);
					
				}catch(Exception e){e.printStackTrace();}
			}
		});
		
		buttonLoadImage.setOnClickListener(new View.OnClickListener() {
            
            @Override
            public void onClick(View arg0) {
                 
                Intent i = new Intent(
                        Intent.ACTION_PICK,
                        android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                 
                startActivityForResult(i, RESULT_LOAD_IMAGE);
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
		
		previousAttemptsYes.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				// TODO Auto-generated method stub
				tv_howManyAttempts.setVisibility(VISIBLE);
				howManyAttempts.setVisibility(VISIBLE);
			}
		});
		previousAttemptsNo.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				// TODO Auto-generated method stub
				tv_howManyAttempts.setVisibility(GONE);
				howManyAttempts.setVisibility(GONE);
			}
		});
		
		sceneIOTypeInside.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				tv_whereInside.setVisibility(VISIBLE);
				sceneIType.setVisibility(VISIBLE);
				tv_doorLocked.setVisibility(VISIBLE);
				doorLockedYes.setVisibility(VISIBLE);
				doorLockedNo.setVisibility(VISIBLE);
				tv_windowsClosed.setVisibility(VISIBLE);
				windowsClosedYes.setVisibility(VISIBLE);
				windowsClosedNo.setVisibility(VISIBLE);
				tv_windowsBroken.setVisibility(VISIBLE);
				windowsBrokenYes.setVisibility(VISIBLE);
				windowsBrokenNo.setVisibility(VISIBLE);
				tv_victimAlone.setVisibility(VISIBLE);
				victimAloneYes.setVisibility(VISIBLE);
				victimAloneNo.setVisibility(VISIBLE);
				
				tv_sceneOType.setVisibility(GONE);
				sceneOType.setVisibility(GONE);
				tv_sceneOTypeOther.setVisibility(GONE);
				sceneOTypeOther.setVisibility(GONE);
			}
		});
		sceneIOTypeOutside.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				tv_whereInside.setVisibility(GONE);
				sceneIType.setVisibility(GONE);
				tv_sceneITypeOther.setVisibility(GONE);
				sceneITypeOther.setVisibility(GONE);
				tv_doorLocked.setVisibility(GONE);
				doorLockedYes.setVisibility(GONE);
				doorLockedNo.setVisibility(GONE);
				tv_windowsClosed.setVisibility(GONE);
				windowsClosedYes.setVisibility(GONE);
				windowsClosedNo.setVisibility(GONE);
				tv_windowsBroken.setVisibility(GONE);
				windowsBrokenYes.setVisibility(GONE);
				windowsBrokenNo.setVisibility(GONE);
				tv_victimAlone.setVisibility(GONE);
				victimAloneYes.setVisibility(GONE);
				victimAloneNo.setVisibility(GONE);
				tv_peopleWithVictim.setVisibility(GONE);
				peopleWithVictim.setVisibility(GONE);
				
				tv_sceneOType.setVisibility(VISIBLE);
				sceneOType.setVisibility(VISIBLE);
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
		
		victimAloneYes.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				tv_peopleWithVictim.setVisibility(GONE);
				peopleWithVictim.setVisibility(GONE);
			}
		});
		victimAloneNo.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				tv_peopleWithVictim.setVisibility(VISIBLE);
				peopleWithVictim.setVisibility(VISIBLE);
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
		

		ligatureAroundNeckYes.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				tv_whoRemovedligature.setVisibility(GONE);
				whoRemovedligature.setVisibility(GONE);
			}
		});
		ligatureAroundNeckNo.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				tv_whoRemovedligature.setVisibility(VISIBLE);
				whoRemovedligature.setVisibility(VISIBLE);
			}
		});
		
		partialHangingYes.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				
				// TODO Auto-generated method stub
				tv_partialHangingType.setVisibility(VISIBLE);
				partialHanging.setVisibility(VISIBLE);
			}
		});
		partialHangingNo.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				tv_partialHangingType.setVisibility(GONE);
				partialHanging.setVisibility(GONE);
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
	
	@Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
         
        if (requestCode == RESULT_LOAD_IMAGE && resultCode == RESULT_OK && null != data) {
            Uri selectedImage = data.getData();
            String[] filePathColumn = { MediaStore.Images.Media.DATA };
 
            Cursor cursor = getContentResolver().query(selectedImage,
            filePathColumn, null, null, null);
            cursor.moveToFirst();
 
            int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
            String picturePath = cursor.getString(columnIndex);
            cursor.close();
           
            uploadFileName.add(picturePath);
           // messageText.setText("Path : "+uploadFileName);
            
            if(count == 0){
            	imageView0.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 1){
            	imageView1.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 2){
            	imageView2.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 3){
            	imageView3.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 4){
            	imageView4.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 5){
            	imageView5.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 6){
            	imageView6.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 7){
            	imageView7.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }else if(count == 8){
            	imageView8.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            }
            count++;
        }
     
     
    }
   
   
 
    public int uploadFile(String sourceFileUri) {
           
           
          String fileName = sourceFileUri;
  
          HttpURLConnection conn = null;
          DataOutputStream dos = null;  
          String lineEnd = "\r\n";
          String twoHyphens = "--";
          String boundary = "*****";
          int bytesRead, bytesAvailable, bufferSize;
          byte[] buffer;
          int maxBufferSize = 1 * 1024 * 1024; 
          File sourceFile = new File(sourceFileUri); 
           
          if (!sourceFile.isFile()) {
               
               dialog.dismiss(); 
                
               Log.e("uploadFile", "Source File not exist :" + filename);
                
               runOnUiThread(new Runnable() {
                   public void run() {
                       messageText.setText("Source File not exist :"+ filename);
                   }
               }); 
                
               return 0;
            
          }
          else
          {
               try { 
                    
                     // open a URL connection to the Servlet
                   FileInputStream fileInputStream = new FileInputStream(sourceFile);
                   URL url = new URL(upLoadServerUri);
                    
                   // Open a HTTP  connection to  the URL
                   conn = (HttpURLConnection) url.openConnection(); 
                   conn.setDoInput(true); // Allow Inputs
                   conn.setDoOutput(true); // Allow Outputs
                   conn.setUseCaches(false); // Don't use a Cached Copy
                   conn.setRequestMethod("POST");
                   conn.setRequestProperty("Connection", "Keep-Alive");
                   conn.setRequestProperty("ENCTYPE", "multipart/form-data");
                   conn.setRequestProperty("Content-Type", "multipart/form-data;boundary=" + boundary);
                   conn.setRequestProperty("uploaded_file", fileName); 
                    
                   dos = new DataOutputStream(conn.getOutputStream());
          
                   dos.writeBytes(twoHyphens + boundary + lineEnd); 
                   dos.writeBytes("Content-Disposition: form-data; name= uploaded_file ;filename="+fileName+ lineEnd);
                    
                   dos.writeBytes(lineEnd);
          
                   // create a buffer of  maximum size
                   bytesAvailable = fileInputStream.available(); 
          
                   bufferSize = Math.min(bytesAvailable, maxBufferSize);
                   buffer = new byte[bufferSize];
          
                   // read file and write it into form...
                   bytesRead = fileInputStream.read(buffer, 0, bufferSize);  
                      
                   while (bytesRead > 0) {
                        
                     dos.write(buffer, 0, bufferSize);
                     bytesAvailable = fileInputStream.available();
                     bufferSize = Math.min(bytesAvailable, maxBufferSize);
                     bytesRead = fileInputStream.read(buffer, 0, bufferSize);   
                      
                    }
          
                   // send multipart form data necesssary after file data...
                   dos.writeBytes(lineEnd);
                   dos.writeBytes(twoHyphens + boundary + twoHyphens + lineEnd);
          
                   // Responses from the server (code and message)
                   serverResponseCode = conn.getResponseCode();
                   String serverResponseMessage = conn.getResponseMessage();
                     
                   Log.i("uploadFile", "HTTP Response is : "
                           + serverResponseMessage + ": " + serverResponseCode);
                    
                   if(serverResponseCode == 200){
                        
                       runOnUiThread(new Runnable() {
                            public void run() {
                                 
                                String msg = "File Upload Completed.\n\n See uploaded file here : \n\n"
                                              +" http://forensicsapp.co.za/webapp/images/uploads/"
                                              +filename;
                                 
                                messageText.setText(msg);
                                Toast.makeText(Hanging.this, "File Upload Complete.", 
                                             Toast.LENGTH_SHORT).show();
                            }
                        });                
                   }    
                    
                   //close the streams //
                   fileInputStream.close();
                   dos.flush();
                   dos.close();
                     
              } catch (MalformedURLException ex) {
                   
                  dialog.dismiss();  
                  ex.printStackTrace();
                   
                  runOnUiThread(new Runnable() {
                      public void run() {
                          messageText.setText("MalformedURLException Exception : check script url.");
                          Toast.makeText(Hanging.this, "MalformedURLException", 
                                                              Toast.LENGTH_SHORT).show();
                      }
                  });
                   
                  Log.e("Upload file to server", "error: " + ex.getMessage(), ex);  
              } catch (Exception e) {
                   
                  dialog.dismiss();  
                  e.printStackTrace();
                   
                  runOnUiThread(new Runnable() {
                      public void run() {
                          messageText.setText("Got Exception : see logcat ");
                          Toast.makeText(Hanging.this, "Got Exception : see logcat ", 
                                  Toast.LENGTH_SHORT).show();
                      }
                  });
                  Log.e("Upload file to server Exception", "Exception : "
                                                   + e.getMessage(), e);  
              }
              dialog.dismiss();       
              return serverResponseCode; 
               
           } // End else block 
         }
    
	private void showHideButtons(){
		
			response.setVisibility(GONE);
			doneButton.setVisibility(VISIBLE);
			logoutButton.setVisibility(GONE);
		
	}
		

	
	
	private List<NameValuePair> getPostData(){
		try{
			List<NameValuePair> pairs = new ArrayList<NameValuePair>();  
	
	        pairs.add(new BasicNameValuePair("rquest",Encryption.bytesToHex(enc.encrypt("addCase"))));
	        pairs.add(new BasicNameValuePair("category",Encryption.bytesToHex(enc.encrypt("hanging"))));
	        JSONObject obj = new JSONObject();
	        JSONArray array = new JSONArray();
	        JSONObject info = new JSONObject();
	        JSONArray vicArray = new JSONArray();
	        JSONObject victims = new JSONObject();
	        
	        
	        info.accumulate("FOPersonelNumber", Encryption.bytesToHex(enc.encrypt(username)));
	        info.accumulate("sceneTime", Encryption.bytesToHex(enc.encrypt(time)));
	        info.accumulate("sceneDate", Encryption.bytesToHex(enc.encrypt(date)));
	        info.accumulate("sceneLocation", Encryption.bytesToHex(enc.encrypt(location)));
	        if(WeatherInfo != null && WeatherInfo.length() != 0 )
	        {
	        	info.accumulate("sceneTemparature", Encryption.bytesToHex(enc.encrypt(WeatherInfo)));
	        }else{
	        	info.accumulate("sceneTemparature", Encryption.bytesToHex(enc.encrypt("23C")));
	        }
	        info.accumulate("investigatingOfficerName", Encryption.bytesToHex(enc.encrypt(ioName.getText().toString())));
	        info.accumulate("investigatingOfficerRank", Encryption.bytesToHex(enc.encrypt(ioRank.getText().toString())));
	        info.accumulate("investigatingOfficerCellNo", Encryption.bytesToHex(enc.encrypt(ioCellNo.getText().toString())));
	        info.accumulate("firstOfficerOnSceneName", Encryption.bytesToHex(enc.encrypt(foosName.getText().toString())));
	        info.accumulate("firstOfficerOnSceneRank", Encryption.bytesToHex(enc.encrypt(foosRank.getText().toString())));
	        knownVictim();
	        victims.accumulate("victimIdentityNumber", Encryption.bytesToHex(enc.encrypt(victimIDNo.getText().toString())));
	        victims.accumulate("victimGender", Encryption.bytesToHex(enc.encrypt(getVictimGender())));
	        victims.accumulate("victimRace", Encryption.bytesToHex(enc.encrypt(getVictimRace())));
	        victims.accumulate("victimName", Encryption.bytesToHex(enc.encrypt(victimName.getText().toString())));
	        victims.accumulate("victimSurname", Encryption.bytesToHex(enc.encrypt(victimSurname.getText().toString())));
	        victims.accumulate("victimAge", Encryption.bytesToHex(enc.encrypt(""+getVictimAge())));
	        victims.accumulate("victimGeneralHistory", Encryption.bytesToHex(enc.encrypt(generalHistory.getText().toString())));
	        
	        //Toast.makeText(getApplicationContext(), bodyDecomposedYes.isChecked()+" checked", Toast.LENGTH_LONG);
	        if(bodyDecomposedYes.isChecked())
	        {
	        	victims.accumulate("bodyDecomposed", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	victims.accumulate("bodyDecomposed", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(medicalInterventionYes.isChecked())
	        {
	        	victims.accumulate("medicalIntervention", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	victims.accumulate("medicalIntervention", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        victims.accumulate("bodyBurned", "null");
	        victims.accumulate("bodyIntact","null");
	        victims.accumulate("whoFoundVictimBody", Encryption.bytesToHex(enc.encrypt(whoFoundVictimBody.getText().toString())));
	        
	        if(closeToWaterYes.isChecked())
	        {
	        	victims.accumulate("victimFoundCloseToWater", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	victims.accumulate("victimFoundCloseToWater", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(suicideSuspectedYes.isChecked())
	        {
	        	victims.accumulate("suicideSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	victims.accumulate("suicideSuspected", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(suicideNoteFoundYes.isChecked())
	        {
	        	victims.accumulate("victimSuicideNoteFound", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	victims.accumulate("victimSuicideNoteFound", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(previousAttemptsYes.isChecked())
	        {
	        	victims.accumulate("previousAttempts", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	victims.accumulate("previousAttempts", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        
	        
	        victims.accumulate("numberOfPreviousAttempts", Encryption.bytesToHex(enc.encrypt(getAttempts()+"")));
	        if(rapeHomicideYes.isChecked())
	        {
	        	victims.accumulate("rapeHomicideSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	victims.accumulate("rapeHomicideSuspected", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(sceneIOTypeInside.isChecked())
	        {
	        	victims.accumulate("victimInside", Encryption.bytesToHex(enc.encrypt("Yes")));
		        victims.accumulate("victimOutside", Encryption.bytesToHex(enc.encrypt("No")));
	        }else{
	        	victims.accumulate("victimInside", Encryption.bytesToHex(enc.encrypt("No")));
		        victims.accumulate("victimOutside", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }
	        
	       
	       
	        vicArray.put(victims);
	        info.accumulate("victims", vicArray);
	        
	        info.accumulate("hangingIOType",getIOType() );
	        if(signsOfStruggleYes.isChecked())
	        {
	        	info.accumulate("signsOfStruggle", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("signsOfStruggle", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        if(alcoholBottleAroundYes.isChecked())
	        {
	        	info.accumulate("alcoholBottleAround", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("alcoholBottleAround", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(drugParaphernaliaYes.isChecked())
	        {
	        	info.accumulate("drugParaphernalia", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("drugParaphernalia", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(strangulationSuspectedYes.isChecked())
	        {
	        	info.accumulate("strangulationSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("strangulationSuspected", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(smotheringSuspectedYes.isChecked())
	        {
	        	info.accumulate("smotheringSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("smotheringSuspected", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(chockingSuspectedYes.isChecked())
	        {
	        	info.accumulate("chockingSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("chockingSuspected", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(doorLockedYes.isChecked())
	        {
	        	info.accumulate("doorLocked", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("doorLocked", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(windowsClosedYes.isChecked())
	        {
	        	info.accumulate("windowsClosed", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("windowsClosed", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        if(windowsBrokenYes.isChecked())
	        {
	        	info.accumulate("windowsBroken", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("windowsBroken", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        if(victimAloneYes.isChecked())
	        {
	        	info.accumulate("victimAlone", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("victimAlone", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        
	        info.accumulate("peopleWithVictim", getPeopleWithVictim());
	        if(autoeroticAsphyxiaYes.isChecked())
	        {
	        	info.accumulate("autoeroticAsphyxia", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("autoeroticAsphyxia", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        info.accumulate("partialHangingType", getPartialHangingType());
	        if(completeHangingFG.isChecked())
	        {
	        	info.accumulate("completeHanging", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("completeHanging", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        if(ligatureAroundNeckYes.isChecked())
	        {
	        	info.accumulate("ligatureAroundNeck", Encryption.bytesToHex(enc.encrypt("Yes")));
	        }else{
	        	info.accumulate("ligatureAroundNeck", Encryption.bytesToHex(enc.encrypt("No")));
	        }
	        
	        info.accumulate("ligatureType", getLigatureType());
	        if(whoRemovedligature.getText().toString() != "" && whoRemovedligature.getText().toString() != null)
	        {
	        	info.accumulate("whoRemovedLigature", Encryption.bytesToHex(enc.encrypt(whoRemovedligature.getText().toString())));
	        }else{
	        	info.accumulate("whoRemovedLigature", null);
	        }
	        
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
			
			if(sceneIOTypeInside.isChecked())
			{
				type = (String)sceneIType.getSelectedItem();
				if(type.toLowerCase().equals("other")){
					type = sceneITypeOther.getText().toString();
				}
				return Encryption.bytesToHex(enc.encrypt(type));
			}else{
				type = (String)sceneOType.getSelectedItem();
				if(type.toLowerCase().equals("other")){
					type = sceneOTypeOther.getText().toString();
				}
				return Encryption.bytesToHex(enc.encrypt(type));
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
	
	public int getAttempts(){
		try{
			
			if(previousAttemptsYes.isChecked())
			{
				int attempts = Integer.parseInt(howManyAttempts.getText().toString());
				return attempts;
			}
		}catch(Exception e){
			howManyAttempts.requestFocus();
			howManyAttempts.setError("A number is required.");
			e.printStackTrace();
		}
		return 0;
	}
	
	public int getVictimAge(){
		try{
			
			if(victimAge.getText().toString().length() != 0)
			{
				int attempts = Integer.parseInt(victimAge.getText().toString());
				return attempts;
			}
		}catch(Exception e){
			victimAge.requestFocus();
			victimAge.setError("A number is required.");
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
        
        
        info.accumulate("FOPersonelNumber", Encryption.bytesToHex(enc.encrypt(username)));
        info.accumulate("sceneTime", Encryption.bytesToHex(enc.encrypt(time)));
        info.accumulate("sceneDate", Encryption.bytesToHex(enc.encrypt(date)));
        info.accumulate("sceneLocation", Encryption.bytesToHex(enc.encrypt(location)));
        if(WeatherInfo != null && WeatherInfo.length() != 0 )
        {
        	info.accumulate("sceneTemparature", Encryption.bytesToHex(enc.encrypt(WeatherInfo)));
        }else{
        	info.accumulate("sceneTemparature", Encryption.bytesToHex(enc.encrypt("23C")));
        }
        info.accumulate("investigatingOfficerName", Encryption.bytesToHex(enc.encrypt(ioName.getText().toString())));
        info.accumulate("investigatingOfficerRank", Encryption.bytesToHex(enc.encrypt(ioRank.getText().toString())));
        info.accumulate("investigatingOfficerCellNo", Encryption.bytesToHex(enc.encrypt(ioCellNo.getText().toString())));
        info.accumulate("firstOfficerOnSceneName", Encryption.bytesToHex(enc.encrypt(foosName.getText().toString())));
        info.accumulate("firstOfficerOnSceneRank", Encryption.bytesToHex(enc.encrypt(foosRank.getText().toString())));
        knownVictim();
        victims.accumulate("victimIdentityNumber", Encryption.bytesToHex(enc.encrypt(victimIDNo.getText().toString())));
        victims.accumulate("victimGender", Encryption.bytesToHex(enc.encrypt(getVictimGender())));
        victims.accumulate("victimRace", Encryption.bytesToHex(enc.encrypt(getVictimRace())));
        victims.accumulate("victimName", Encryption.bytesToHex(enc.encrypt(victimName.getText().toString())));
        victims.accumulate("victimSurname", Encryption.bytesToHex(enc.encrypt(victimSurname.getText().toString())));
        victims.accumulate("victimAge", Encryption.bytesToHex(enc.encrypt(""+getVictimAge())));
        victims.accumulate("victimGeneralHistory", Encryption.bytesToHex(enc.encrypt(generalHistory.getText().toString())));
        
        //Toast.makeText(getApplicationContext(), bodyDecomposedYes.isChecked()+" checked", Toast.LENGTH_LONG);
        if(bodyDecomposedYes.isChecked())
        {
        	victims.accumulate("bodyDecomposed", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	victims.accumulate("bodyDecomposed", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(medicalInterventionYes.isChecked())
        {
        	victims.accumulate("medicalIntervention", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	victims.accumulate("medicalIntervention", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        victims.accumulate("bodyBurned", "null");
        victims.accumulate("bodyIntact","null");
        victims.accumulate("whoFoundVictimBody", Encryption.bytesToHex(enc.encrypt(whoFoundVictimBody.getText().toString())));
        
        if(closeToWaterYes.isChecked())
        {
        	victims.accumulate("victimFoundCloseToWater", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	victims.accumulate("victimFoundCloseToWater", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(suicideSuspectedYes.isChecked())
        {
        	victims.accumulate("suicideSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	victims.accumulate("suicideSuspected", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(suicideNoteFoundYes.isChecked())
        {
        	victims.accumulate("victimSuicideNoteFound", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	victims.accumulate("victimSuicideNoteFound", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(previousAttemptsYes.isChecked())
        {
        	victims.accumulate("previousAttempts", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	victims.accumulate("previousAttempts", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        
        
        victims.accumulate("numberOfPreviousAttempts", Encryption.bytesToHex(enc.encrypt(getAttempts()+"")));
        if(rapeHomicideYes.isChecked())
        {
        	victims.accumulate("rapeHomicideSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	victims.accumulate("rapeHomicideSuspected", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(sceneIOTypeInside.isChecked())
        {
        	victims.accumulate("victimInside", Encryption.bytesToHex(enc.encrypt("Yes")));
	        victims.accumulate("victimOutside", Encryption.bytesToHex(enc.encrypt("No")));
        }else{
        	victims.accumulate("victimInside", Encryption.bytesToHex(enc.encrypt("No")));
	        victims.accumulate("victimOutside", Encryption.bytesToHex(enc.encrypt("Yes")));
        }
        
       
       
        vicArray.put(victims);
        info.accumulate("victims", vicArray);
        
        info.accumulate("hangingIOType",getIOType() );
        if(signsOfStruggleYes.isChecked())
        {
        	info.accumulate("signsOfStruggle", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("signsOfStruggle", Encryption.bytesToHex(enc.encrypt("No")));
        }
        if(alcoholBottleAroundYes.isChecked())
        {
        	info.accumulate("alcoholBottleAround", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("alcoholBottleAround", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(drugParaphernaliaYes.isChecked())
        {
        	info.accumulate("drugParaphernalia", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("drugParaphernalia", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(strangulationSuspectedYes.isChecked())
        {
        	info.accumulate("strangulationSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("strangulationSuspected", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(smotheringSuspectedYes.isChecked())
        {
        	info.accumulate("smotheringSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("smotheringSuspected", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(chockingSuspectedYes.isChecked())
        {
        	info.accumulate("chockingSuspected", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("chockingSuspected", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(doorLockedYes.isChecked())
        {
        	info.accumulate("doorLocked", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("doorLocked", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        if(windowsClosedYes.isChecked())
        {
        	info.accumulate("windowsClosed", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("windowsClosed", Encryption.bytesToHex(enc.encrypt("No")));
        }
        if(windowsBrokenYes.isChecked())
        {
        	info.accumulate("windowsBroken", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("windowsBroken", Encryption.bytesToHex(enc.encrypt("No")));
        }
        if(victimAloneYes.isChecked())
        {
        	info.accumulate("victimAlone", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("victimAlone", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        
        info.accumulate("peopleWithVictim", getPeopleWithVictim());
        if(autoeroticAsphyxiaYes.isChecked())
        {
        	info.accumulate("autoeroticAsphyxia", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("autoeroticAsphyxia", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        info.accumulate("partialHangingType", getPartialHangingType());
        if(completeHangingFG.isChecked())
        {
        	info.accumulate("completeHanging", Encryption.bytesToHex(enc.encrypt("feet of ground")));
        }else{
        	info.accumulate("completeHanging", Encryption.bytesToHex(enc.encrypt("fully suspended")));
        }
        
        if(ligatureAroundNeckYes.isChecked())
        {
        	info.accumulate("ligatureAroundNeck", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	info.accumulate("ligatureAroundNeck", Encryption.bytesToHex(enc.encrypt("No")));
        }
        
        info.accumulate("ligatureType", getLigatureType());
        if(whoRemovedligature.getText().toString() != "" && whoRemovedligature.getText().toString() != null)
        {
        	info.accumulate("whoRemovedLigature", Encryption.bytesToHex(enc.encrypt(whoRemovedligature.getText().toString())));
        }else{
        	info.accumulate("whoRemovedLigature", null);
        }
                
        
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
				return Encryption.bytesToHex(enc.encrypt(ligatureTypeOther.getText().toString()));
			}else{
				
				return Encryption.bytesToHex(enc.encrypt(item));
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		return "";
	}
	public String getPeopleWithVictim(){
		try{
			
			
			if(victimAloneNo.isChecked())
			{
				return Encryption.bytesToHex(enc.encrypt(peopleWithVictim.getText().toString()));
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
			if(partialHangingYes.isChecked())
			{
				String item = (String)partialHanging.getSelectedItem();
				if(item.toLowerCase().equals("other"))
				{
					return Encryption.bytesToHex(enc.encrypt(partialHangingOther.getText().toString()));
				}else{
					
					return Encryption.bytesToHex(enc.encrypt(item));
				}
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		return "No";
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
    
    
    
private boolean ValidateFields(){
		
		if(ioName.getText().toString().length() == 0){
			ioName.requestFocus();
			ioName.setError("sorry empty field");
			return false;
		}
		
		if( ioSurname.getText().toString().length() == 0){
			ioSurname.requestFocus();
			ioSurname.setError("sorry empty field");
			return false;
		}
		
		
		if( ioRank.getText().toString().length() == 0){
			ioRank.requestFocus();
			ioRank.setError("sorry empty field");
			return false;
		}

		
		if( ioCellNo.getText().toString().length() == 0){
			ioCellNo.requestFocus();
			ioCellNo.setError("sorry empty field");
			return false;
		}
		if(!CellNoValidation(ioCellNo.getText().toString()) || ioCellNo.getText().toString().length() != 10){
			ioCellNo.requestFocus();
			ioCellNo.setError("sorry invalid cell no");
			return false;
		}
		
		if( foosName.getText().toString().length() == 0){
			foosName.requestFocus();
			foosName.setError("sorry empty field");
			return false;
		}
		
		if( foosSurname.getText().toString().length() == 0){
			foosSurname.requestFocus();
			foosSurname.setError("sorry empty field");
			return false;
		}
		
		if( foosRank.getText().toString().length() == 0){
			foosRank.requestFocus();
			foosRank.setError("sorry empty field");
			return false;
		}
		
		if( victimName.getText().toString().length() == 0){
			victimName.requestFocus();
			victimName.setError("sorry empty field");
			return false;
		}
		
		if( victimSurname.getText().toString().length() == 0){
			victimSurname.requestFocus();
			victimSurname.setError("sorry empty field");
			return false;
		}
		
		if( victimIDNo.getText().toString().length() == 0){
			victimIDNo.requestFocus();
			victimIDNo.setError("sorry empty field");
			return false;
		}
		
		
			
		if( whoFoundVictimBody.getText().toString().length() == 0){
			whoFoundVictimBody.requestFocus();
			whoFoundVictimBody.setError("sorry empty field");
			return false;
		}
		
		
		if(ligatureAroundNeckNo.isChecked())
		{
			if( whoRemovedligature.getText().toString().length() == 0){
				whoRemovedligature.requestFocus();
				whoRemovedligature.setError("sorry empty field");
				return false;
			}
		}
		
		if(partialHangingYes.isChecked())
		{
			String selectedItem = (String)partialHanging.getSelectedItem();
			if(selectedItem.toLowerCase().equals("other"))
			{
				if( partialHangingOther.getText().toString().length() == 0){
					partialHangingOther.requestFocus();
					partialHangingOther.setError("sorry empty field");
					return false;
				}
			}
		}
		
		String selectedItem = (String)ligatureType.getSelectedItem();
		if(selectedItem.toLowerCase().equals("other"))
		{
			if( ligatureTypeOther.getText().toString().length() == 0){
				ligatureTypeOther.requestFocus();
				ligatureTypeOther.setError("sorry empty field");
				return false;
			}
		}
		
		if(sceneIOTypeInside.isChecked()){
			
			doorLockedNo.setChecked(true);
			
			windowsClosedNo.setChecked(true);
		
			windowsBrokenNo.setChecked(true);
		
			victimAloneNo.setChecked(true);
			
			if(previousAttemptsYes.isChecked()){
				if( howManyAttempts.getText().toString().length() == 0){
					howManyAttempts.requestFocus();
					howManyAttempts.setError("sorry empty field");
					return false;
				}
			}
			
			
			
				
				
		}
		
		
		if( generalHistory.getText().toString().length() == 0){
			generalHistory.requestFocus();
			generalHistory.setError("sorry empty field");
			return false;
		}
		return true;
	}
	
	private void CheckRadioButtons(){
		
		try{
		rgbUnknownGender.setChecked(true);
		rgbUnknownRace.setChecked(true);
		
		//outside selected by default
		sceneIOTypeOutside.setChecked(true);
		tv_whereInside.setVisibility(GONE);
		sceneIType.setVisibility(GONE);
		tv_sceneITypeOther.setVisibility(GONE);
		sceneITypeOther.setVisibility(GONE);
		tv_doorLocked.setVisibility(GONE);
		doorLockedYes.setVisibility(GONE);
		doorLockedNo.setVisibility(GONE);
		tv_windowsClosed.setVisibility(GONE);
		windowsClosedYes.setVisibility(GONE);
		windowsClosedNo.setVisibility(GONE);
		tv_windowsBroken.setVisibility(GONE);
		windowsBrokenYes.setVisibility(GONE);
		windowsBrokenNo.setVisibility(GONE);
		tv_victimAlone.setVisibility(GONE);
		victimAloneYes.setVisibility(GONE);
		victimAloneNo.setVisibility(GONE);
		tv_peopleWithVictim.setVisibility(GONE);
		peopleWithVictim.setVisibility(GONE);
		
		tv_sceneOType.setVisibility(VISIBLE);
		sceneOType.setVisibility(VISIBLE);
		
		suicideNoteFoundNo.setChecked(true);
		
		bodyDecomposedNo.setChecked(true);
	
		medicalInterventionNo.setChecked(true);
	
		closeToWaterNo.setChecked(true);
		
		rapeHomicideNo.setChecked(true);
	
		suicideSuspectedNo.setChecked(true);
		
		//previous attempts is none by default
		previousAttemptsNo.setChecked(true);
		tv_howManyAttempts.setVisibility(GONE);
		howManyAttempts.setVisibility(GONE);
	
		signsOfStruggleNo.setChecked(true);
		
		alcoholBottleAroundNo.setChecked(true);
	
		drugParaphernaliaNo.setChecked(true);
	
		autoeroticAsphyxiaNo.setChecked(true);
	
		partialHangingNo.setChecked(true);
		completeHangingFG.setChecked(true);
		ligatureAroundNeckNo.setChecked(true);
		
		strangulationSuspectedNo.setChecked(true);
	
		smotheringSuspectedNo.setChecked(true);
		
		chockingSuspectedNo.setChecked(true);
	
		}catch(Exception e){e.printStackTrace();} 
	}
	
	private  boolean CellNoValidation(String cell) {
		  return cell.matches("[-+]?\\d+(\\.\\d+)?");
	}
	
	private class JSONWeatherTask extends AsyncTask<String, Void, Weather> {
		
		@Override
		protected Weather doInBackground(String... params) {
			Weather weather = new Weather();
			String data = ( (new WeatherHttpClient()).getWeatherData(params[0]));

			try {
				weather = JSONWeatherParser.getWeather(data);
				
				// Let's retrieve the icon
				//weather.iconData = ( (new WeatherHttpClient()).getImage(weather.currentCondition.getIcon()));
				
			} catch (JSONException e) {				
				e.printStackTrace();
			}
			return weather;
		
	}
		
		
		@Override
		protected void onPostExecute(Weather weather) {			
			super.onPostExecute(weather);
			
			/*if (weather.iconData != null && weather.iconData.length > 0) {
				Bitmap img = BitmapFactory.decodeByteArray(weather.iconData, 0, weather.iconData.length); 
				imgView.setImageBitmap(img);
			}*/
			try{
				WeatherInfo = ""+Math.round((weather.temperature.getTemp() - 273.15))+" Degree Celcius";
			}catch(Exception e){
				e.printStackTrace();
			}
			//weatherInfo.setText(WeatherInfo);
			/*cityText.setText(weather.location.getCity() + "," + weather.location.getCountry());
			condDescr.setText(weather.currentCondition.getCondition() + "(" + weather.currentCondition.getDescr() + ")");*/
			/*temp.setText("" + Math.round((weather.temperature.getTemp() - 273.15)) + "�C");*/
			/*hum.setText("" + weather.currentCondition.getHumidity() + "%");
			press.setText("" + weather.currentCondition.getPressure() + " hPa");
			windSpeed.setText("" + weather.wind.getSpeed() + " mps");
			windDeg.setText("" + weather.wind.getDeg() + "�");*/
				
		}
	}
}
