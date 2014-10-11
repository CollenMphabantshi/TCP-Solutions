package com.example.mobileforensics;

import android.app.Activity;
import android.app.ListActivity;
import android.content.Intent;
import android.location.LocationManager;
import android.os.Bundle;
import android.provider.Settings;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

public class SceneMenu extends Activity{
	String menu[] = {"colled","mal"};
	ListView list;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.scenemenu);
		LocationManager service = (LocationManager) getSystemService(LOCATION_SERVICE);
		boolean enabled = service.isProviderEnabled(LocationManager.GPS_PROVIDER);
		if (!enabled) {
			  Intent intent = new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS);
			  Toast.makeText(this, "Enabled :" + enabled, Toast.LENGTH_SHORT).show();
			  startActivity(intent);
			} 
		
		//get Listview from xml
		list = (ListView) findViewById(R.id.list);
		
		 // Defined Array values to show in ListView
        String[] values = new String[] { "Sudden unexpected death of an infant (SUDI)",
						        		 "Sudden unexpected death of a child  (1 – 18 years)",
						        		 "Sudden unexpected death of an adult/ found dead",
						        		 "Foetus / Abandoned baby", 
                                         "Section 56  death –surgical case", 
                                         "Road traffic accidents (Pedestrian vehicle accident)", 
                                         "Road traffic accidents (Bicycle accident)", 
                                         "Road traffic accidents (Motorbike accident)", 
                                         "Road traffic accidents (Motor vehicle accident)", 
                                         "Railway accident", 
                                         "Aviation accident", 
                                         "Fall/push/jump from height", 
                                         "Crush injury", 
                                         "Firearm discharge/  gunshot wound", 
                                         "Sharp force injury/ stab injury", 
                                         "Blunt force injury/ assault" , 
                                         "Drowning", 
                                         "Gassing" , 
                                         "Hanging", 
                                         "Ingestion/overdose /poisoning" , 
                                         "Burns", 
                                         "Lightning/ electrocution"  
                                         
                                        };
        final String[] classes = new String[] {"Sudi","Sudc","Suda","Foetusabandonedbaby","Sec56"
        		,"Pedestrian","Bicycle","Mba","Mva","Railway","Aviation","Fromheight","Crushinjury"
        		,"Firearm","Sharp","Blunt","Drowning","Gassing","Hanging","Ingestionoverdosepoisoning","Burn","Electrocutionlightning"};
        
        // Define a new Adapter
        // First parameter - Context
        // Second parameter - Layout for the row
        // Third parameter - ID of the TextView to which the data is written
        // Forth - the Array of data

        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
          android.R.layout.simple_list_item_1, android.R.id.text1, values);
        // Assign adapter to ListView
        list.setAdapter(adapter);
        
        list.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,int position, long id) {
				// TODO Auto-generated method stub
				
				int pos = position;
				
				String itemValue = (String) list.getItemAtPosition(position);
				
				String selectedClass = classes[pos];
				
				try {
					
					Class myClass = Class.forName("com.example.mobileforensics."+selectedClass);
					
					Intent select = new Intent(SceneMenu.this,myClass);
					try{
						select.putExtra("USERNAME", getIntent().getExtras().getString("USERNAME"));
					}catch(Exception e){e.printStackTrace();}
					startActivity(select);
					
				} catch (ClassNotFoundException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				
				//Toast.makeText(getApplicationContext(), "Positio "+pos+" ListItem: "+itemValue, Toast.LENGTH_LONG).show();
				
			}
        	
		});
        
		
	}
	
}
