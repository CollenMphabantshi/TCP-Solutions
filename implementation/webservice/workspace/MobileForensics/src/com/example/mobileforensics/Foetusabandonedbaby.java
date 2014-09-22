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
import android.graphics.Matrix;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationManager;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.provider.Settings;
import android.support.v4.app.NavUtils;
import android.text.format.Time;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Gallery;
import android.widget.GridLayout;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Foetusabandonedbaby extends Activity implements GlobalMethods, OnMyLocationChangeListener{
	
	
	
	TextView value;

	
	

	private EditText ioName;
	
	private EditText ioSurname;
	
	private EditText ioRank;
	
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
	
	private TextView sceneOfInjury;
	private TextView tv_sceneIOType;
	private RadioButton sceneIOTypeInside;
	private RadioButton sceneIOTypeOutside;
	private TextView tv_whereInside;
	private Spinner sceneIType;
	private TextView tv_sceneITypeOther;
	private EditText sceneITypeOther;
	private TextView tv_sceneOType;
	private Spinner sceneOType;
	private TextView tv_sceneOTypeOther;
	private EditText sceneOTypeOther;
	
	private TextView sceneLook;
	
	private TextView theScene;
	private TextView tv_generalHistory;
	private EditText generalHistory;
	
	private TextView response;

	private Button doneButton;
	private Button logoutButton;
	private Button BackToMenu;
	private GridLayout Gallery;
	private JSONObject json;

	
	private final static int PAGES = 6;

	private final static int VISIBLE = View.VISIBLE;
	private final static int INVISIBLE = View.INVISIBLE;
	private final static int GONE = View.GONE;
	
	
	private String username;
	private String time;
	private String date;
	private String location;
	
	private JSONObject currentDataSaved;
	
	GoogleMap map;
	private JSONObject locate;
	private double longitude;
	private double latitude;
	private int status;
	private String myAddress;
	
	
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
	private int index_gallery= 0;
	
	private String mCurrentPhotoPath;
	static final int REQUEST_TAKE_PHOTO = 1;
	//ImageView mImageView;
	private static final String TAG = "upload";
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		//String city = "lat=-25.7547642&lon=28.2146178";
		String city = "";
		super.onCreate(savedInstanceState);
		setContentView(R.layout.foetusabandoned);
		LocationManager service = (LocationManager) getSystemService(LOCATION_SERVICE);
		boolean enabled = service.isProviderEnabled(LocationManager.GPS_PROVIDER);
		if (!enabled) {
			  Intent intent = new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS);
			  Toast.makeText(this, "Enabled :" + enabled, Toast.LENGTH_SHORT).show();
			  startActivity(intent);
			} 
		status = GooglePlayServicesUtil.isGooglePlayServicesAvailable(getBaseContext());
		
		
		
		initialize();
		System.out.println("Start init");
		variablesInitialization();
		CheckRadioButtons();
		setOnClickEvents();
		
		
	
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
				
				String city = "lat="+latitude+"&lon="+longitude;
				JSONWeatherTask task = new JSONWeatherTask();
				task.execute(new String[]{city});
				location +="\n"+WeatherInfo;
			}
			return location;
			
		}
	
	private File createImageFile() throws IOException{
		// Create an image file name
	    String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
	    String imageFileName = "foetus_" + timeStamp + "_";
	    String storageDir = Environment.getExternalStorageDirectory() + "/picupload";
	    File dir = new File(storageDir);
	    if (!dir.exists())
	    	dir.mkdir();
	    
	    File image = new File(storageDir + "/" + imageFileName + ".jpg");

	    // Save a file: path for use with ACTION_VIEW intents
	    mCurrentPhotoPath = image.getAbsolutePath();
	    Log.i(TAG, "photo path = " + mCurrentPhotoPath);
	    return image;
		
	}
	
	private void dispatchTakePictureIntent(){
		
		Intent takePictureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
		
		if(takePictureIntent.resolveActivity(getPackageManager()) != null){
			
			File photoFile = null;
			try{
				photoFile = createImageFile();
			}catch(IOException ex){
				ex.printStackTrace();
			}
			
			if(photoFile != null){
				takePictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, Uri.fromFile(photoFile));
				startActivityForResult(takePictureIntent, REQUEST_TAKE_PHOTO);
			}
		}
	}
	
	private void setPic(ImageView mImageView){
		// Get the dimensions of the View
	    int targetW = 300;
	    int targetH = 300;

	    // Get the dimensions of the bitmap
	    BitmapFactory.Options bmOptions = new BitmapFactory.Options();
	    bmOptions.inJustDecodeBounds = true;
	    BitmapFactory.decodeFile(mCurrentPhotoPath, bmOptions);
	    int photoW = bmOptions.outWidth;
	    int photoH = bmOptions.outHeight;

	    // Determine how much to scale down the image
	    int scaleFactor = Math.min(photoW/targetW, photoH/targetH);

	    // Decode the image file into a Bitmap sized to fill the View
	    bmOptions.inJustDecodeBounds = false;
	    bmOptions.inSampleSize = scaleFactor << 1;
	    bmOptions.inPurgeable = true;

	    Bitmap bitmap = BitmapFactory.decodeFile(mCurrentPhotoPath, bmOptions);
	    
	    Matrix mtx = new Matrix();
	    mtx.postRotate(90);
	    // Rotating Bitmap
	    Bitmap rotatedBMP = Bitmap.createBitmap(bitmap, 0, 0, bitmap.getWidth(), bitmap.getHeight(), mtx, true);

	    if (rotatedBMP != bitmap)
	    	bitmap.recycle();
	    
	    mImageView.setImageBitmap(rotatedBMP);
	    galleryAddPic(mCurrentPhotoPath);
		
	}
	
	private void galleryAddPic(String locat){
		
		Intent mediaScanerIntent = new Intent(Intent.ACTION_MEDIA_SCANNER_SCAN_FILE);
		
		File f = new File(locat);
		
		Uri counterUri = Uri.fromFile(f);
		
		mediaScanerIntent.setData(counterUri);
		
		this.sendBroadcast(mediaScanerIntent);
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
			
		} catch (Exception e) {
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
		try{
		enc = new Encryption();
		try{
			username = getIntent().getExtras().getString("USERNAME");
		}catch(Exception e){e.printStackTrace();}
		
		try{
			//time = new Time().format("%H:%M:%S");
			System.out.println("TIME: "+time);
		    //date = new Time().format("%Y-%m-%d");
		    System.out.println("TIME: "+date);
		}catch(Exception e){
			e.printStackTrace();
			
		}
		
		
		
	
		ioName = (EditText)findViewById(R.id.foetus_io_name);
		
		ioSurname = (EditText)findViewById(R.id.foetus_io_surname);
		
		ioRank = (EditText)findViewById(R.id.foetus_io_rank);
		
		ioCellNo = (EditText)findViewById(R.id.foetus_io_cell);
		
		tv_foosName = (TextView)findViewById(R.id.foetus_tv_foos_name);
		foosName = (EditText)findViewById(R.id.foetus_foos_name);
		tv_foosSurname = (TextView)findViewById(R.id.foetus_tv_foos_surname);
		foosSurname = (EditText)findViewById(R.id.foetus_foos_surname);
		tv_foosRank = (TextView)findViewById(R.id.foetus_tv_foos_rank);
		foosRank = (EditText)findViewById(R.id.foetus_foos_rank);
		
	
		
		tv_victimName = (TextView)findViewById(R.id.foetus_tv_victim_name);
		victimName = (EditText)findViewById(R.id.foetus_victim_name);
		tv_victimSurname = (TextView)findViewById(R.id.foetus_tv_victim_surname);
		victimSurname = (EditText)findViewById(R.id.foetus_victim_surname);
		tv_victimIDNo = (TextView)findViewById(R.id.foetus_tv_victim_id);
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
		tv_bodyDecomposed = (TextView)findViewById(R.id.foetus_tv_bodyDecomposed);
		bodyDecomposedYes = (RadioButton)findViewById(R.id.foetus_bodyDecomposedYes);
		bodyDecomposedNo = (RadioButton)findViewById(R.id.foetus_bodyDecomposedNo);
		tv_medicalIntervention = (TextView)findViewById(R.id.foetus_tv_medicalIntervention);
		medicalInterventionYes = (RadioButton)findViewById(R.id.foetus_medicalInterventionYes);
		medicalInterventionNo = (RadioButton)findViewById(R.id.foetus_medicalInterventionNo);
		tv_whoFoundVictimBody = (TextView)findViewById(R.id.foetus_tv_whoFoundVictimBody);
		whoFoundVictimBody = (EditText)findViewById(R.id.foetus_whoFoundVictimBody);
		tv_closeToWater = (TextView)findViewById(R.id.foetus_tv_closeToWater);
		closeToWaterYes = (RadioButton)findViewById(R.id.foetus_closeToWaterYes);
		closeToWaterNo = (RadioButton)findViewById(R.id.foetus_closeToWaterNo);
		
		
		sceneOfInjury = (TextView)findViewById(R.id.foetus_sceneOfInjury);
		tv_sceneIOType = (TextView)findViewById(R.id.foetus_tv_sceneIOType);
		sceneIOTypeInside = (RadioButton)findViewById(R.id.foetus_SceneIOTypeInside);
		sceneIOTypeOutside = (RadioButton)findViewById(R.id.foetus_SceneIOTypeOutside);
		tv_whereInside = (TextView)findViewById(R.id.foetus_tv_whereInside);
		sceneIType = (Spinner)findViewById(R.id.foetus_sceneIType);
		tv_sceneITypeOther = (TextView)findViewById(R.id.foetus_tv_sceneITypeOther);
		sceneITypeOther = (EditText)findViewById(R.id.foetus_sceneITypeOther);
		tv_sceneOType = (TextView)findViewById(R.id.foetus_tv_sceneOType);
		sceneOType = (Spinner)findViewById(R.id.foetus_sceneOType);
		tv_sceneOTypeOther = (TextView)findViewById(R.id.foetus_tv_sceneOTypeOther);
		sceneOTypeOther = (EditText)findViewById(R.id.foetus_sceneOTypeOther);
		
		System.out.println("after page 3");
		
		theScene = (TextView)findViewById(R.id.foetus_theScene);
		tv_generalHistory = (TextView)findViewById(R.id.foetus_tv_generalHistory);
		generalHistory = (EditText)findViewById(R.id.foetus_generalHistory);
		
		
		response = (TextView)findViewById(R.id.foetus_tv_response);
		
		doneButton = (Button)findViewById(R.id.foetus_doneButton);
		logoutButton = (Button)findViewById(R.id.foetus_logoutButton);
		
		BackToMenu = (Button)findViewById(R.id.foetus_BackToMenu);
		
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
	       
	       Gallery = (GridLayout) findViewById(R.id.foetus_galleryLayout);
	       // weather section
	       weatherInfo = (TextView) findViewById(R.id.foetusWeatherInfo);
		
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
		
		
		doneButton.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View view) {
				// TODO Auto-generated method stub
				try{
					//submit data to the server
					List<NameValuePair> postdata = getPostData();
					if(postdata != null)
					{
						if(ValidateFields()){
							if(uploadFileName.size() > 0){
								
									try{
										
										new Read().execute(postdata);
										
										dialog = ProgressDialog.show(Foetusabandonedbaby.this, "", "Uploading file...", true);
						                 
						                new Thread(new Runnable() {
						                        public void run() {
						                             runOnUiThread(new Runnable() {
						                                    public void run() {
						                                        
						                                        Toast.makeText(Foetusabandonedbaby.this, "uploading started.....", Toast.LENGTH_SHORT).show();
						                                    }
						                                });                      
						                             for(int i=0; i < uploadFileName.size(); i++){
						                            	 filename = uploadFileName.get(i);
						                            	 System.out.println("/////////         "+uploadFileName.get(i)+"    \\\\\\\\\\\\\\\\\\\\");
						                            	 uploadFile( filename );
						                            	 
						                             }                   
						                        }
						                      }).start(); 
						                doneButton.setVisibility(VISIBLE);
										logoutButton.setVisibility(VISIBLE);
										clearFilelds();
										Toast.makeText(Foetusabandonedbaby.this, "form successfully filled", Toast.LENGTH_SHORT).show();
									}catch(Exception e){
										e.printStackTrace();
									}
										
							}
							else{
								
								Toast.makeText(Foetusabandonedbaby.this, "Sorry no photos to upload", Toast.LENGTH_SHORT).show();
								
							}
						}else{
							Toast.makeText(Foetusabandonedbaby.this, "Sorry fields must be filled", Toast.LENGTH_SHORT).show();
						}
						
					}
					
					//nextButton.setVisibility(GONE);
					
				}catch(Exception e){e.printStackTrace();}
			}
		});
		
		buttonLoadImage.setOnClickListener(new View.OnClickListener() {
            
            @Override
            public void onClick(View arg0) {
            	if(index_gallery < 9){
            	
	            	if(index_gallery == 0){
	            		imageView0.setVisibility(VISIBLE);
	            		dispatchTakePictureIntent();
	            		index_gallery++;
	            	}else if(index_gallery == 1){
	            		imageView1.setVisibility(VISIBLE);
	            		dispatchTakePictureIntent();
	            		index_gallery++;
	            	}else if(index_gallery == 2){
	            		imageView2.setVisibility(VISIBLE);
	            		dispatchTakePictureIntent();
	            		index_gallery++;
	            	}else if(index_gallery == 3){
	            		imageView3.setVisibility(VISIBLE);
	            		dispatchTakePictureIntent();
	            		index_gallery++;
	            	}else if(index_gallery == 4){
	            		imageView4.setVisibility(VISIBLE);
	            		dispatchTakePictureIntent();
	            		index_gallery++;
	            	}else if(index_gallery == 5){
	            		imageView5.setVisibility(VISIBLE);
	            		dispatchTakePictureIntent();
	            		index_gallery++;
	            	}else if(index_gallery == 6){
	            		imageView6.setVisibility(VISIBLE);
	            		dispatchTakePictureIntent();
	            		index_gallery++;
	            	}else if(index_gallery == 7){
	            		imageView7.setVisibility(VISIBLE);
	            		dispatchTakePictureIntent();
	            		index_gallery++;
	            	}else if(index_gallery == 8){
	            		imageView8.setVisibility(VISIBLE);
	            		dispatchTakePictureIntent();
	            		index_gallery++;
	            	}
            	}
            	
            }
        });
	
		
		logoutButton.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View view) {
				// TODO Auto-generated method stub
				List<NameValuePair> pairs = new ArrayList<NameValuePair>();  
				
		        pairs.add(new BasicNameValuePair("rquest","addCase"));
		        //check 
		        pairs.add(new BasicNameValuePair("category","foetus"));
		        pairs.add(new BasicNameValuePair("caseData",currentDataSaved.toString()));
		        new Read().execute(pairs);
			}
		});
		
		
		
		/**
		 * 	Spinner onclick event
		 */


		sceneIOTypeInside.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				tv_whereInside.setVisibility(VISIBLE);
				sceneIType.setVisibility(VISIBLE);
				
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
	
	    @Override
	    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	        super.onActivityResult(requestCode, resultCode, data);
	         
	        Log.i(TAG, "onActivityResult: " + this);
			if (requestCode == REQUEST_TAKE_PHOTO && resultCode == Activity.RESULT_OK) {
	        	
	            uploadFileName.add(mCurrentPhotoPath);
	            System.out.println("******************   "+mCurrentPhotoPath);
	           
	            if(count == 0){
	            	setPic(imageView0);
	            	
	            }else if(count == 1){
	            	setPic(imageView1);
	            	
	            }else if(count == 2){
	            	setPic(imageView2);
	            	
	            }else if(count == 3){
	            	setPic(imageView3);
	            	
	            }else if(count == 4){
	            	setPic(imageView4);
	            	
	            }else if(count == 5){
	            	setPic(imageView5);
	            	
	            }else if(count == 6){
	            	setPic(imageView6);
	            	
	            }else if(count == 7){
	            	setPic(imageView7);
	            	
	            }else if(count == 8){
	            	setPic(imageView8);
	            	
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
	                                Toast.makeText(Foetusabandonedbaby.this, "File Upload Complete.", 
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
	                          Toast.makeText(Foetusabandonedbaby.this, "MalformedURLException", 
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
	                          Toast.makeText(Foetusabandonedbaby.this, "Got Exception : see logcat ", 
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
	        pairs.add(new BasicNameValuePair("category",Encryption.bytesToHex(enc.encrypt("foetus"))));
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
	        
	        info.accumulate("foetusabandonedbabyIOType",getIOType() );
	        
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
	
	
	public void saveDataOnAction() throws Exception{
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
        victims.accumulate("bodyIntact", "null");
        victims.accumulate("whoFoundVictimBody", Encryption.bytesToHex(enc.encrypt(whoFoundVictimBody.getText().toString())));
        
        if(closeToWaterYes.isChecked())
        {
        	victims.accumulate("victimFoundCloseToWater", Encryption.bytesToHex(enc.encrypt("Yes")));
        }else{
        	victims.accumulate("victimFoundCloseToWater", Encryption.bytesToHex(enc.encrypt("No")));
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
        
        info.accumulate("foetusabandonedbabyIOType",getIOType() );
       
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
				WeatherInfo = ""+Math.round((weather.temperature.getTemp() - 273.15))+" Degree Celcius";
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
	

	
	private boolean ValidateFields(){
		System.out.println("**********    ****************    "+uploadFileName);
		if(ioName.getText().toString().trim().length() == 0){
			ioName.requestFocus();
			ioName.setError("sorry empty field");
			return false;
		}
		
		if( ioSurname.getText().toString().trim().length() == 0){
			ioSurname.requestFocus();
			ioSurname.setError("sorry empty field");
			return false;
		}
		
		
		if( ioRank.getText().toString().trim().length() == 0){
			ioRank.requestFocus();
			ioRank.setError("sorry empty field");
			return false;
		}

		
		if( ioCellNo.getText().toString().trim().length() == 0){
			ioCellNo.requestFocus();
			ioCellNo.setError("sorry empty field");
			return false;
		}
		if(!CellNoValidation(ioCellNo.getText().toString().trim()) || ioCellNo.getText().toString().trim().length() != 10){
			ioCellNo.requestFocus();
			ioCellNo.setError("sorry invalid cell no");
			return false;
		}
		
		if( foosName.getText().toString().trim().length() == 0){
			foosName.requestFocus();
			foosName.setError("sorry empty field");
			return false;
		}
		
		if( foosSurname.getText().toString().trim().length() == 0){
			foosSurname.requestFocus();
			foosSurname.setError("sorry empty field");
			return false;
		}
		
		if( foosRank.getText().toString().trim().length() == 0){
			foosRank.requestFocus();
			foosRank.setError("sorry empty field");
			return false;
		}
		
		if( victimName.getText().toString().trim().length() == 0){
			victimName.requestFocus();
			victimName.setError("sorry empty field");
			return false;
		}
		
		if( victimSurname.getText().toString().trim().length() == 0){
			victimSurname.requestFocus();
			victimSurname.setError("sorry empty field");
			return false;
		}
		
		if( victimIDNo.getText().toString().trim().length() == 0){
			victimIDNo.requestFocus();
			victimIDNo.setError("sorry empty field");
			return false;
		}
			
		if( whoFoundVictimBody.getText().toString().trim().length() == 0){
			whoFoundVictimBody.requestFocus();
			whoFoundVictimBody.setError("sorry empty field");
			return false;
		}
		
		if(sceneIOTypeInside.isChecked()){
			
			
		}
		
		if( generalHistory.getText().toString().length() == 0){
			generalHistory.requestFocus();
			generalHistory.setError("sorry empty field");
			return false;
		}
		return true;
	}
	
	public void clearFilelds(){
		
		victimName.setText("Unknown");
		
		victimSurname.setText("Unknown");
		
		victimIDNo.setText("Unknown");
			
		whoFoundVictimBody.setText("");
		
		if(sceneIOTypeInside.isChecked()){
			sceneIOTypeInside.setChecked(false);
			//outside selected by default
			sceneIOTypeOutside.setChecked(true);
			tv_whereInside.setVisibility(GONE);
			sceneIType.setVisibility(GONE);
			tv_sceneITypeOther.setVisibility(GONE);
			sceneITypeOther.setVisibility(GONE);
			
		}
		generalHistory.setText("");
		
		uploadFileName = null;
		
		uploadFileName = new ArrayList<String>();
		
	    imageView0.setImageBitmap(null);
	    imageView1.setImageBitmap(null);
	    imageView2.setImageBitmap(null);
	    imageView3.setImageBitmap(null);
	    imageView4.setImageBitmap(null);
	    imageView5.setImageBitmap(null);
	    imageView6.setImageBitmap(null);
	    imageView7.setImageBitmap(null);
	    imageView8.setImageBitmap(null);
	    
	    imageView0.setVisibility(GONE);
	    imageView1.setVisibility(GONE);
	    imageView2.setVisibility(GONE);
	    imageView3.setVisibility(GONE);
	    imageView4.setVisibility(GONE);
	    imageView5.setVisibility(GONE);
	    imageView6.setVisibility(GONE);
	    imageView7.setVisibility(GONE);
	    imageView8.setVisibility(GONE);
			
	   index_gallery = 0;
	   count = 0;
	}
	
	private void CheckRadioButtons(){
		
		rgbUnknownGender.setChecked(true);
		rgbUnknownRace.setChecked(true);
		
		//outside selected by default
		sceneIOTypeOutside.setChecked(true);
		tv_whereInside.setVisibility(GONE);
		sceneIType.setVisibility(GONE);
		tv_sceneITypeOther.setVisibility(GONE);
		sceneITypeOther.setVisibility(GONE);
		
		tv_sceneOType.setVisibility(VISIBLE);
		sceneOType.setVisibility(VISIBLE);
		
		
		bodyDecomposedNo.setChecked(true);
	
		medicalInterventionNo.setChecked(true);
	
		closeToWaterNo.setChecked(true);
		
	}
	
	private  boolean CellNoValidation(String cell) {
		  return cell.matches("[-+]?\\d+(\\.\\d+)?");
		}
	
	
	
	
}
