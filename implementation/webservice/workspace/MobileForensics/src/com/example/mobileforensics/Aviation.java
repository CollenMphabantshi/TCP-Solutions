package com.example.mobileforensics;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
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



import com.example.mobileforensics.R;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.GoogleMap.OnMyLocationChangeListener;

import com.example.mobileforensics.JSONWeatherParser;
import com.example.mobileforensics.WeatherHttpClient;
import com.example.mobileforensics.models.Weather;

import android.app.Activity;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.GridLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Aviation extends Activity implements GlobalMethods, OnMyLocationChangeListener{
	
	Button next;
	
	TextView value;

	private LinearLayout infoLayout;
	private LinearLayout demographicsLayout;
	private GridLayout theBodyLayout;
	private GridLayout sceneOfInjuryLayout;
	private GridLayout sceneLookLayout;
	private GridLayout theSceneLayout;
	private LinearLayout galleryLayout;
	
	private TextView aviation_tv_ioName;
	private EditText aviation_ioName;
	private TextView aviation_tv_ioSurname;
	private EditText aviation_ioSurname;
	private TextView aviation_tv_ioRank;
	private EditText aviation_ioRank;
	private TextView aviation_tv_ioCellNo;
	private EditText aviation_ioCellNo;
	
	private TextView aviation_tv_foosName;
	private EditText aviation_foosName;
	private TextView aviation_tv_foosSurname;
	private EditText aviation_foosSurname;
	private TextView aviation_tv_foosRank;
	private EditText aviation_foosRank;
	
	private TextView aviation_tv_victimName;
	private EditText aviation_victimName;
	private TextView aviation_tv_victimSurname;
	private EditText aviation_victimSurname;
	private TextView aviation_tv_victimIDNo;
	private EditText aviation_victimIDNo;
	
	private TextView aviation_tv_victimInfo;
	private TextView aviation_tv_victimRace;
	private TextView aviation_tv_victimGender;
	private TextView aviation_tv_foos;
	private TextView aviation_tv_io;
	
	
	private RadioButton aviation_rgbMale;
	private RadioButton aviation_rgbFemale;
	private RadioButton aviation_rgbUnknownGender;
	
	private RadioButton aviation_rgbAsian;
	private RadioButton aviation_rgbBlack;
	private RadioButton aviation_rgbColoured;
	private RadioButton aviation_rgbWhite;
	private RadioButton aviation_rgbUnknownRace;

	private TextView aviation_theBody;
	private TextView aviation_tv_bodyDecomposed;
	private RadioButton aviation_bodyDecomposedYes;
	private RadioButton aviation_bodyDecomposedNo;
	private TextView aviation_tv_medicalIntervention;
	private RadioButton aviation_medicalInterventionYes;
	private RadioButton aviation_medicalInterventionNo;
	private TextView aviation_tv_whoFoundVictimBody;
	private EditText aviation_whoFoundVictimBody;
	private TextView aviation_tv_closeToWater;
	private RadioButton aviation_closeToWaterYes;
	private RadioButton aviation_closeToWaterNo;
	private TextView aviation_tv_bodySeverelyBurned;
	private RadioButton aviation_bodySeverelyBurnedYes;
	private RadioButton aviation_bodySeverelyBurnedNo;
	private TextView aviation_tv_bodyIntact;
	private RadioButton aviation_bodyIntactYes;
	private RadioButton aviation_bodyIntactNo;
	
	private TextView aviation_sceneOfInjury;
	private TextView aviation_tv_whereOutside;
	private Spinner aviation_sceneOType;
	private TextView aviation_tv_sceneOTypeOther;
	private EditText aviation_sceneOTypeOther;
	
	
	private TextView theScene;
	private TextView aviation_tv_suicideNoteFound;
	private RadioButton aviation_suicideNoteFoundYes;
	private RadioButton aviation_suicideNoteFoundNo;
	private TextView aviation_tv_generalHistory;
	private EditText aviation_generalHistory;
	
	private TextView response;
	private Button nextButton;
	private Button doneButton;
	private Button logoutButton;
	
	private JSONObject json;

	
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
	private JSONObject currentDataSaved;
	
	GoogleMap map;
	private JSONObject locate;
	private double longitude;
	private double latitude;
	private int status;
	private String myAddress;
	private String Text;
	
	Button geolocation;
	
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
    private TextView cityText;
	private TextView condDescr;
	private TextView temp;
	private TextView press;
	private TextView windSpeed;
	private TextView windDeg;
	
	private TextView hum;
	private ImageView imgView;
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.aviation);
		
		status = GooglePlayServicesUtil.isGooglePlayServicesAvailable(getBaseContext());
		
		
		
		//initialize();
		System.out.println("Start init");
		variablesInitialization();
		setOnClickEvents();
		
		//hidePage();
		//showPage();
		//showHideButtons();
	
	}
	
	public String initialize(){
			
			if( status != ConnectionResult.SUCCESS){
				int requestCode = 10;
				Dialog dialog = GooglePlayServicesUtil.getErrorDialog(status, this, requestCode);
				dialog.show();
			}else{
				
				map = ((MapFragment) getFragmentManager().findFragmentById(R.id.fragId)).getMap();
				map.setMyLocationEnabled(true);
				map.setOnMyLocationChangeListener(this);
				
			}
			return location;
			
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
		  myAddress = "Cannot get Address!";
	 }
	}

	private void variablesInitialization(){
		pageCount = 1;
		username = "p33333333";
		try{
		
		time = (new Random().nextLong())+"";
	    date = "2014-10-10";
		temperature = "23 C";
		location = (new Random().nextLong())+","+(new Random().nextLong());
		geolocation = (Button) findViewById(R.id.geolocation);
		infoLayout = (LinearLayout)findViewById(R.id.aviation_infoLayout);
		demographicsLayout = (LinearLayout)findViewById(R.id.aviation_demographicLayout);
		theBodyLayout = (GridLayout)findViewById(R.id.aviation_theBodyLayout);
		sceneOfInjuryLayout = (GridLayout)findViewById(R.id.aviation_sceneOfInjuryLayout);
		theSceneLayout = (GridLayout)findViewById(R.id.aviation_theSceneLayout);
		galleryLayout = (LinearLayout)findViewById(R.id.aviation_galleryLayout);
		
		aviation_tv_ioName = (TextView)findViewById(R.id.aviation_tv_io_name);
		aviation_ioName = (EditText)findViewById(R.id.aviation_io_name);
		aviation_tv_ioSurname = (TextView)findViewById(R.id.aviation_tv_io_surname);
		aviation_ioSurname = (EditText)findViewById(R.id.aviation_io_surname);
		aviation_tv_ioRank = (TextView)findViewById(R.id.aviation_tv_io_rank);
		aviation_ioRank = (EditText)findViewById(R.id.aviation_io_rank);
		aviation_tv_ioCellNo = (TextView)findViewById(R.id.aviation_tv_io_cell);
		aviation_ioCellNo = (EditText)findViewById(R.id.aviation_io_cell);
		
		aviation_tv_foosName = (TextView)findViewById(R.id.aviation_tv_foos_name);
		aviation_foosName = (EditText)findViewById(R.id.aviation_foos_name);
		aviation_tv_foosSurname = (TextView)findViewById(R.id.aviation_tv_foos_surname);
		aviation_foosSurname = (EditText)findViewById(R.id.aviation_foos_surname);
		aviation_tv_foosRank = (TextView)findViewById(R.id.aviation_tv_foos_rank);
		aviation_foosRank = (EditText)findViewById(R.id.aviation_foos_rank);
		
		aviation_tv_io = (TextView)findViewById(R.id.aviation_tv_io);
		aviation_tv_foos = (TextView)findViewById(R.id.aviation_tv_foos);
		aviation_tv_victimInfo = (TextView)findViewById(R.id.aviation_tv_victimInfo);
		aviation_tv_victimRace = (TextView)findViewById(R.id.aviation_tv_victimRace);
		aviation_tv_victimGender = (TextView)findViewById(R.id.aviation_tv_victimGender);
		
		aviation_tv_victimName = (TextView)findViewById(R.id.aviation_tv_victim_name);
		aviation_victimName = (EditText)findViewById(R.id.aviation_victim_name);
		aviation_tv_victimSurname = (TextView)findViewById(R.id.aviation_tv_victim_surname);
		aviation_victimSurname = (EditText)findViewById(R.id.aviation_victim_surname);
		aviation_tv_victimIDNo = (TextView)findViewById(R.id.aviation_tv_victim_id);
		aviation_victimIDNo = (EditText)findViewById(R.id.aviation_victim_id);
		
		aviation_rgbMale = (RadioButton)findViewById(R.id.aviation_rgbMale);
		aviation_rgbFemale = (RadioButton)findViewById(R.id.aviation_rgbFemale);
		aviation_rgbUnknownGender = (RadioButton)findViewById(R.id.aviation_rgbUnknownGender);
		
		aviation_rgbAsian = (RadioButton)findViewById(R.id.aviation_rgbAsian);
		aviation_rgbBlack = (RadioButton)findViewById(R.id.aviation_rgbBlack);
		aviation_rgbColoured = (RadioButton)findViewById(R.id.aviation_rgbColoured);
		aviation_rgbWhite = (RadioButton)findViewById(R.id.aviation_rgbWhite);
		aviation_rgbUnknownRace = (RadioButton)findViewById(R.id.aviation_rgbUnknownRace);
		
		
		aviation_theBody = (TextView)findViewById(R.id.aviation_tv_the_body);
		aviation_tv_bodyDecomposed = (TextView)findViewById(R.id.aviation_tv_bodyDecomposed);
		aviation_bodyDecomposedYes = (RadioButton)findViewById(R.id.aviation_bodyDecomposedYes);
		aviation_bodyDecomposedNo = (RadioButton)findViewById(R.id.aviation_bodyDecomposedNo);
		aviation_tv_medicalIntervention = (TextView)findViewById(R.id.aviation_tv_medicalIntervention);
		aviation_medicalInterventionYes = (RadioButton)findViewById(R.id.aviation_medicalInterventionYes);
		aviation_medicalInterventionNo = (RadioButton)findViewById(R.id.aviation_medicalInterventionNo);
		aviation_tv_closeToWater = (TextView)findViewById(R.id.aviation_tv_closeToWater);
		aviation_closeToWaterYes = (RadioButton)findViewById(R.id.aviation_closeToWaterYes);
		aviation_closeToWaterNo = (RadioButton)findViewById(R.id.aviation_closeToWaterNo);
		aviation_tv_bodySeverelyBurned = (TextView)findViewById(R.id.aviation_tv_bodySeverelyBurned);
		aviation_bodySeverelyBurnedYes = (RadioButton)findViewById(R.id.aviation_bodySeverelyBurnedYes);
		aviation_bodySeverelyBurnedNo = (RadioButton)findViewById(R.id.aviation_bodySeverelyBurnedNo);
		aviation_tv_bodyIntact = (TextView)findViewById(R.id.aviation_tv_bodyIntact);
		aviation_bodyIntactYes = (RadioButton)findViewById(R.id.aviation_bodyIntactYes);
		aviation_bodyIntactNo = (RadioButton)findViewById(R.id.aviation_bodyIntactNo);
		
		
		aviation_sceneOfInjury = (TextView)findViewById(R.id.aviation_sceneOfInjury);
		aviation_sceneOType = (Spinner)findViewById(R.id.aviation_sceneOType);
		aviation_tv_sceneOTypeOther = (TextView)findViewById(R.id.aviation_tv_sceneOTypeOther);
		aviation_sceneOTypeOther = (EditText)findViewById(R.id.aviation_sceneOTypeOther);
		
		
		
		theScene = (TextView)findViewById(R.id.aviation_theScene);
		aviation_tv_suicideNoteFound = (TextView)findViewById(R.id.aviation_tv_suicideNoteFound);
		aviation_suicideNoteFoundYes = (RadioButton)findViewById(R.id.aviation_SuicideNoteFoundYes);
		aviation_tv_generalHistory = (TextView)findViewById(R.id.aviation_tv_generalHistory);
		aviation_generalHistory = (EditText)findViewById(R.id.aviation_generalHistory);
		
		
		response = (TextView)findViewById(R.id.aviation_tv_response);
		nextButton = (Button)findViewById(R.id.aviation_nextButton);
		doneButton = (Button)findViewById(R.id.aviation_doneButton);
		logoutButton = (Button)findViewById(R.id.aviation_logoutButton);
		
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
	       	cityText = (TextView) findViewById(R.id.cityText);
			condDescr = (TextView) findViewById(R.id.condDescr);
			temp = (TextView) findViewById(R.id.temp);
			hum = (TextView) findViewById(R.id.hum);
			press = (TextView) findViewById(R.id.press);
			windSpeed = (TextView) findViewById(R.id.windSpeed);
			windDeg = (TextView) findViewById(R.id.windDeg);
			imgView = (ImageView) findViewById(R.id.condIcon);
		
		
		}catch(Exception e){
			e.printStackTrace();
		}
	}
	
	
	
	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
	}
	
	public void setOnClickEvents(){
		
		geolocation.setOnClickListener(new View.OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				// TODO Auto-generated method stub
				initialize();
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
						try{
							new Read().execute(postdata);
							
							dialog = ProgressDialog.show(Aviation.this, "", "Uploading file...", true);
			                 
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
						}catch(Exception e){
							e.printStackTrace();
						}
						
					}
					
					//nextButton.setVisibility(GONE);
					doneButton.setVisibility(GONE);
					logoutButton.setVisibility(VISIBLE);
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
		        pairs.add(new BasicNameValuePair("category","aviation"));
		        pairs.add(new BasicNameValuePair("caseData",currentDataSaved.toString()));
		        new Read().execute(pairs);
			}
		});
		
		/**
		 * 	Spinner onclick event
		 */
		

		aviation_sceneOType.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				aviation_sceneOType.setVisibility(VISIBLE);
				aviation_tv_sceneOTypeOther.setVisibility(VISIBLE);
				aviation_sceneOTypeOther.setVisibility(VISIBLE);
			}
		});
	
		
		
		aviation_sceneOType.setOnItemSelectedListener(new OnItemSelectedListener() {

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
							aviation_tv_sceneOTypeOther.setVisibility(VISIBLE);
							aviation_sceneOTypeOther.setVisibility(VISIBLE);
						}else{
							aviation_tv_sceneOTypeOther.setVisibility(GONE);
							aviation_sceneOTypeOther.setVisibility(GONE);
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
	                                Toast.makeText(Aviation.this, "File Upload Complete.", 
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
	                          Toast.makeText(Aviation.this, "MalformedURLException", 
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
	                          Toast.makeText(Aviation.this, "Got Exception : see logcat ", 
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
	
	
	public List<NameValuePair> getPostData(){
		try{
			List<NameValuePair> pairs = new ArrayList<NameValuePair>();  
	
	        pairs.add(new BasicNameValuePair("rquest","addCase"));
	        pairs.add(new BasicNameValuePair("category","aviation"));
	        JSONObject obj = new JSONObject();
	        JSONArray array = new JSONArray();
	        JSONObject info = new JSONObject();
	        JSONArray vicArray = new JSONArray();
	        JSONObject victims = new JSONObject();
	        
	        
	        info.accumulate("FOPersonelNumber",username);
	        info.accumulate("sceneTime", time);
	        info.accumulate("sceneDate", date);
	        info.accumulate("sceneLocation", location);
	        info.accumulate("sceneTemparature", temperature);
	        info.accumulate("investigatingOfficerName", aviation_ioName.getText().toString());
	        info.accumulate("investigatingOfficerRank", aviation_ioRank.getText().toString());
	        info.accumulate("investigatingOfficerCellNo", aviation_ioCellNo.getText().toString());
	        info.accumulate("firstOfficerOnSceneName", aviation_foosName.getText().toString());
	        info.accumulate("firstOfficerOnSceneRank", aviation_foosRank.getText().toString());
	        knownVictim();
	        victims.accumulate("victimIdentityNumber", aviation_victimIDNo.getText().toString());
	        victims.accumulate("victimGender", getVictimGender());
	        victims.accumulate("victimRace", getVictimRace());
	        victims.accumulate("victimName", aviation_victimName.getText().toString());
	        victims.accumulate("victimSurname", aviation_victimSurname.getText().toString());
	        victims.accumulate("victimGeneralHistory", aviation_generalHistory.getText().toString());
	        victims.accumulate("scenePhoto", null);
	        //Toast.makeText(getApplicationContext(), bodyDecomposedYes.isChecked()+" checked", Toast.LENGTH_LONG);
	        if(aviation_bodyDecomposedYes.isChecked())
	        {
	        	victims.accumulate("bodyDecomposed", "Yes");
	        }else{
	        	victims.accumulate("bodyDecomposed", "No");
	        }
	        
	        if(aviation_medicalInterventionYes.isChecked())
	        {
	        	victims.accumulate("medicalIntervention", "yes");
	        }else{
	        	victims.accumulate("medicalIntervention", "no");
	        }
	        
	        if(aviation_closeToWaterYes.isChecked())
	        {
	        	victims.accumulate("victimFoundCloseToWater", "yes");
	        }else{
	        	victims.accumulate("victimFoundCloseToWater", "no");
	        }
	        
	        if(aviation_bodySeverelyBurnedYes.isChecked())
	        {
	        	victims.accumulate("bodySeverelyBurned", "Yes");
	        }else{
	        	victims.accumulate("bodySeverelyBurned", "No");
	        }
	        
	        if(aviation_bodyIntactYes.isChecked())
	        {
	        	victims.accumulate("bodyIntact", "Yes");
	        }else{
	        	victims.accumulate("bodyIntact", "No");
	        }
	        
	        
	        if(aviation_suicideNoteFoundYes.isChecked())
	        {
	        	victims.accumulate("victimSuicideNoteFound", "yes");
	        }else{
	        	victims.accumulate("victimSuicideNoteFound", "no");
	        }  
	       
	        vicArray.put(victims);
	        info.accumulate("victims", vicArray);
     
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
	
	
	public String getVictimGender(){
		try{
			
			
			if(aviation_rgbMale.isChecked())
			{
				return "Male";
			}else if(aviation_rgbFemale.isChecked())
			{
				return "Female";
			}else if(aviation_rgbUnknownGender.isChecked())
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
			
			
			if(aviation_rgbAsian.isChecked())
			{
				return "Asian";
			}else if(aviation_rgbBlack.isChecked())
			{
				return "Black";
			}else if(aviation_rgbColoured.isChecked())
			{
				return "Coloured";
			}else if(aviation_rgbWhite.isChecked())
			{
				return "White";
			}else if(aviation_rgbUnknownRace.isChecked())
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
			if(aviation_victimName.getText().toString().equals(""))
			{
				aviation_victimName.setText("Unknown");
				aviation_victimSurname.setText("Unknown");
				aviation_victimIDNo.setText("Unknown");
			}
		}catch(Exception e){
			e.printStackTrace();
		}
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
        info.accumulate("investigatingOfficerName", aviation_ioName.getText().toString());
        info.accumulate("investigatingOfficerRank", aviation_ioRank.getText().toString());
        info.accumulate("investigatingOfficerCellNo", aviation_ioCellNo.getText().toString());
        info.accumulate("firstOfficerOnSceneName", aviation_foosName.getText().toString());
        info.accumulate("firstOfficerOnSceneRank", aviation_foosRank.getText().toString());
        knownVictim();
        victims.accumulate("victimIdentityNumber", aviation_victimIDNo.getText().toString());
        victims.accumulate("victimGender", getVictimGender());
        victims.accumulate("victimRace", getVictimRace());
        victims.accumulate("victimName", aviation_victimName.getText().toString());
        victims.accumulate("victimSurname", aviation_victimSurname.getText().toString());
        victims.accumulate("victimGeneralHistory", aviation_generalHistory.getText().toString());
        victims.accumulate("scenePhoto", null);
 
       
        
        if(aviation_bodyDecomposedYes.isChecked())
        {
        	victims.accumulate("bodyDecomposed", "Yes");
        }else{
        	victims.accumulate("bodyDecomposed", "No");
        }
        
        if(aviation_medicalInterventionYes.isChecked())
        {
        	victims.accumulate("medicalIntervention", "yes");
        }else{
        	victims.accumulate("medicalIntervention", "no");
        }
        
        victims.accumulate("whoFoundVictimBody", aviation_whoFoundVictimBody.getText().toString());
        
        if(aviation_closeToWaterYes.isChecked())
        {
        	victims.accumulate("victimFoundCloseToWater", "yes");
        }else{
        	victims.accumulate("victimFoundCloseToWater", "no");
        }
        
        if(aviation_bodySeverelyBurnedYes.isChecked())
        {
        	victims.accumulate("bodySeverelyBurned", "Yes");
        }else{
        	victims.accumulate("bodySeverelyBurned", "No");
        }
        
        if(aviation_bodyIntactYes.isChecked())
        {
        	victims.accumulate("bodyIntact", "Yes");
        }else{
        	victims.accumulate("bodyIntact", "No");
        }
        
        if(aviation_suicideNoteFoundYes.isChecked())
        {
        	victims.accumulate("victimSuicideNoteFound", "yes");
        }else{
        	victims.accumulate("victimSuicideNoteFound", "no");
        }

        
       
        vicArray.put(victims);
        info.accumulate("victims", vicArray);
        
        
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

	@Override
	public void hidePage() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void showPage() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public boolean validateNextPage() {
		// TODO Auto-generated method stub
		return false;
	}

	@Override
	public void showHideButtons() {
		// TODO Auto-generated method stub
		
	}

	private class JSONWeatherTask extends AsyncTask<String, Void, Weather> {
			
			@Override
			protected Weather doInBackground(String... params) {
				Weather weather = new Weather();
				String data = ( (new WeatherHttpClient()).getWeatherData(params[0]));
	
				try {
					weather = JSONWeatherParser.getWeather(data);
					
					// Let's retrieve the icon
					weather.iconData = ( (new WeatherHttpClient()).getImage(weather.currentCondition.getIcon()));
					
				} catch (JSONException e) {				
					e.printStackTrace();
				}
				return weather;
			
		}
		}
	
	
	
}
