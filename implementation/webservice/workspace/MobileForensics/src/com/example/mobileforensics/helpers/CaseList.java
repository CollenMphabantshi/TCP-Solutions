package com.example.mobileforensics.helpers;

import java.util.ArrayList;

public class CaseList extends ArrayList<Case>{

	public ArrayList<String> findCase(String search){
		ArrayList<String> list = new ArrayList<String>();
		for(int i = 0; i < this.size();i++)
		{
			if(this.get(i).getSceneType().toLowerCase().contains(search.toLowerCase())
				|| this.get(i).getSceneDate().toLowerCase().contains(search.toLowerCase())
				|| this.get(i).getSceneTime().toLowerCase().contains(search.toLowerCase()) ){
				System.out.println(">>>>>>>> FOUND: "+ this.get(i).getSceneTime());
				list.add(this.get(i).getSceneType()+"\t\t"+this.get(i).getSceneDate()+"\t"+this.get(i).getSceneTime());
			}
		}
		return list;
	}
}