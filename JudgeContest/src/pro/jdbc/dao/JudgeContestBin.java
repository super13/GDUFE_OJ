package pro.jdbc.dao;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.LineNumberReader;
import java.util.List;

import pro.jdbc.dao.impl.DaoSpringImpl;
import pro.jdbc.domain.Conpro;
import pro.jdbc.domain.Contest;
import pro.jdbc.domain.Crank;
import pro.jdbc.domain.Cstatu;
public class JudgeContestBin implements Runnable{
	public void copyFile(String oldPath, String newPath) {
		try {                   
			int byteread = 0;            
			File oldfile = new File(oldPath);            
			if (oldfile.exists()) { //文件存在时                
				InputStream inStream = new FileInputStream(oldPath); //读入原文件                
				@SuppressWarnings("resource")
				FileOutputStream fs = new FileOutputStream(newPath);                
				byte[] buffer = new byte[1444];                
				while ( (byteread = inStream.read(buffer)) != -1) {                                       
					fs.write(buffer, 0, byteread);                
				}                
				inStream.close();            
			}        
		}  catch (Exception e) {
			//System.out.println("复制单个文件操作出错");            
			e.printStackTrace();        
		}    
	}
	
	public String handleStr(String str,int pid){
		String  strarray[]=str.split("c");
	
			for (int i = 0; i < strarray.length; i++) {
				if(strarray[i].equals(String.valueOf(pid))){
					strarray[i+1]=Integer.parseInt(strarray[i+1])+1+"";
				}
			}	
		String restr="";
		for (int i = 0; i < strarray.length; i++)
			restr+=strarray[i]+"c";
		return restr;
	}
    public boolean isExist(String folder, String type) {

        File f = new File(folder);
        String[] fileList = f.list();

        for(String str:fileList) {
            File file = new File(str);
            if(file.isFile() && file.getName().startsWith(type)) {
            	return true;
            }
        }
        return false;
    }	
    //mode 2为Java 1为c/c++ 判断哪个RE
	public String diffCase(String path,int cid,int ProID,int mode, long usetime, int limitedtime){
		String ans = null;
		if(usetime>limitedtime)
			return "Time Limit Exceeded!";
        Process process;
		try {
			String cmd="./diff -q "+path+"/"+cid+"/stdio/"+ProID+".out "+path + ProID+".out";
			String cmd1="./diff -q -w -B -i "+path+"/"+cid+"/stdio/"+ProID+".out "+path + ProID+".out";
			process = Runtime.getRuntime().exec(cmd);
	        InputStreamReader reader = new InputStreamReader(process.getInputStream());
	        LineNumberReader line = new LineNumberReader(reader);
	        if(line.readLine()!=null){
				process = Runtime.getRuntime().exec(cmd1);
		        InputStreamReader reader1 = new InputStreamReader(process.getInputStream());
		        LineNumberReader line1 = new LineNumberReader(reader1);
		        if(line1.readLine()==null)
		        	return "Presentation Error!";
		        if(isExist(".", "core")&&mode==1)
		        	return "Runtime Error!";
				String path1="/var/www/html/goj/Common/contest/"; //路径
				File runerror= new File(path1 +"runerror.log");
				if(runerror.exists() && runerror.length()>0&&mode==2)
					return "Runtime Error!";
		        return "Wrong Answer!";
	                
	        }else{  	   
	        	return "Accepted!";            		   
	        }	     
		} catch (IOException e) {
			e.printStackTrace();
		}		
		return ans;		
	}
	
	@Override
	public void run() {
		while(true){
			BaseDao baseDao = new DaoSpringImpl();
			Object[] statuobj={"Queuing"};
			String[] statuarg ={"result"};
			String[] crankarg={"user","cid"};//根据账号查找用户
			String[] proarg={"pid","cid"};
			String[] contestarg={"contest_id"};
			List<Cstatu> status = baseDao.findByProperties(statuarg,  Cstatu.class,statuobj);
			//查找提交代码所属题目
			if(status.size()>0){
				final List<Conpro> problems=baseDao.findByProperties(proarg, Conpro.class,status.get(0).getProblem_id(),status.get(0).getCid());
				
				List<Contest> contest=baseDao.findByProperties(contestarg, Contest.class,status.get(0).getCid());
				//查找提交代码的用户
				List<Crank> crank= baseDao.findByProperties(crankarg,  Crank.class,status.get(0).getUser(),status.get(0).getCid());	
				if(crank.size()>0&&contest.size()>0&&problems.size()>0){
					try{
					status.get(0).setResult("Compiling");
					baseDao.update(statuarg, status.get(0));
					
					//问题的提交数+1
					problems.get(0).setTotal(problems.get(0).getTotal()+1);	
					
					//开始时间			
					long minute=(status.get(0).getTime().getTime()-contest.get(0).getStart_time().getTime())/1000/60;	
					
					//拷贝文件到Main
					String path="/var/www/html/goj/Common/contest/"; //路径
					
					//删除相关程序文件
					File eMain = new File(path +"Main");
					File MainCpp = new File(path +"Main.cpp");
					File MainC = new File(path +"Main.c");
					File MainJ =new File(path +"Main.java");
					File MainClass=new File(path +"Main.class");
					File errorlog= new File(path +"error.log");
					File runerror= new File(path +"runerror.log");
					MainC.delete();
					MainCpp.delete();
					eMain.delete();
					MainJ.delete();
					MainClass.delete();
					errorlog.delete();
					runerror.delete();
					Runtime.getRuntime().exec("./OJrmcore"); //删除RE产生的core文件
					int ProID=status.get(0).getProblem_id();
					switch(status.get(0).getLang()){    
						case "C++":{
							copyFile(path+"code/"+status.get(0).getCstatu_id()
								,path+"Main.cpp");
					        String[] compileCMD={"/bin/sh","-c","./OJg++"};
				            Process processC=Runtime.getRuntime().exec(compileCMD);
				            processC.waitFor();
				                //编译完成				          
						}break;
						case "C":{
							copyFile(path+"code/"+status.get(0).getCstatu_id()
									,path+"Main.c");	
					        String[] compileCMD={"/bin/sh","-c","./OJgcc"};
				            Process processC=Runtime.getRuntime().exec(compileCMD);
				            processC.waitFor();
				                //编译完成		
						}break;
						case "Java":{
							copyFile(path+"code/"+status.get(0).getCstatu_id()
									,path+"Main.java");	
					        String[] compileCMD={"/bin/sh","-c","./OJjavac"};
					        Process processC=Runtime.getRuntime().exec(compileCMD);
					        processC.waitFor();
						}break;	                
	
					}
					String[] statuargs ={"result","use_time"};
					switch(status.get(0).getLang()){
					case "Java":{
						if(MainClass.exists()){
							String javapath="/usr/lib/jvm/java-7-sun/bin/java ";
							String[] runCMD={"/bin/sh","-c",javapath+"Main " +
			                		"<"+path+status.get(0).getCid()+"/stdio/"+ProID+".in > " +
			                		path +ProID+".out 2>runerror.log"};	
							
		                	status.get(0).setResult("Running");
							baseDao.update(statuargs, status.get(0));
							
							long startTime=System.currentTimeMillis();//开始时间							
							//开始测试普通的输入数据
			                final Process processR=Runtime.getRuntime().exec(runCMD);
			                
			                new Thread(new Runnable(){
			                @Override
			                public void run() {
			                    try {
			                        Thread.sleep(problems.get(0).getRunTimeout());
			                    } catch (InterruptedException e) {
			                    	e.printStackTrace();
			                    }
			                    processR.destroy();
			                }}).start();			               		                
			                processR.waitFor();	
			                //结束普通数据测试
			                	
			                long endTime=System.currentTimeMillis();//结束时间
			                //结束判断超时的测试
			                
				                status.get(0).setUse_time(endTime-startTime);
				                Runtime.getRuntime().exec("./OJpkill"); //防止程序出错不能正常结束
				                String s=diffCase(path,status.get(0).getCid(),ProID,
				                		2,endTime-startTime,problems.get(0).getCalTimeout());
								status.get(0).setResult(s);
								baseDao.update(statuargs, status.get(0));		                		                
			                }else{
			                	//没有正常编译	        
								copyFile(path+"error.log"
										,path+"errorLog/"+status.get(0).getCstatu_id()+".log");
			    				status.get(0).setResult("Compilation Error");
			    				baseDao.update(statuargs, status.get(0));
			                }					
						}break;
					default:{			              
		                if(eMain.exists()){
			                //运行
							String[] runCMD={"/bin/sh","-c",path+"Main " +
			                		"<"+path+status.get(0).getCid()+"/stdio/"+ProID+".in > " +
			                		path +ProID+".out 2>runerror.log"};
							
		                	status.get(0).setResult("Running");
							baseDao.update(statuargs, status.get(0));
							
							
		                	status.get(0).setResult("Running");
							baseDao.update(statuargs, status.get(0));
							long startTime=System.currentTimeMillis();//开始时间							
							//开始测试普通的输入数据
			                final Process processR=Runtime.getRuntime().exec(runCMD);
			                
			                new Thread(new Runnable(){
			                @Override
			                public void run() {
			                    try {
			                        Thread.sleep(problems.get(0).getRunTimeout());
			                    } catch (InterruptedException e) {
			                    	e.printStackTrace();
			                    }
			                    processR.destroy();
			                }}).start();			               		                
			                processR.waitFor();	
			                //结束普通数据测试
			                
			                long endTime=System.currentTimeMillis();//结束时间
			                //结束判断超时的测试
				                
				                status.get(0).setUse_time(endTime-startTime);
				                
				                Runtime.getRuntime().exec("./OJpkill"); //防止程序出错不能正常结束
				                
				                String s=diffCase(path,status.get(0).getCid(),ProID,
				                		1,endTime-startTime,problems.get(0).getCalTimeout());
								status.get(0).setResult(s);
								baseDao.update(statuargs, status.get(0));		                		                
			                }else{
			                	//没有正常编译	
								copyFile(path+"error.log"
										,path+"errorLog/"+status.get(0).getCstatu_id()+".log");
			    				status.get(0).setResult("Compilation Error");
			    				baseDao.update(statuargs, status.get(0));
			                }
					}
				}
					
					
					
	            	//如果上面的结果是ac，则用户解决题目数加1，解决题目号加上
	        		switch (status.get(0).getResult()){
		        		case "Accepted!":{
		        			problems.get(0).setAc(problems.get(0).getAc()+1);      			
		        			break;
		        		}
		        		case "Wrong Answer!":{
			        			problems.get(0).setWa(problems.get(0).getWa()+1);			        			
			        			break;
		        		}
		        		case "Presentation Error!":	{        			
			        			problems.get(0).setPe(problems.get(0).getPe()+1);
			        			break;
		        			}
		        		case "Compilation Error":	{        			
			        			problems.get(0).setCe(problems.get(0).getCe()+1);
			        			break;
		        			}
		        		case "Time Limit Exceeded!":	{        			
		        			problems.get(0).setTle(problems.get(0).getTle()+1);
		        			break;
		    			}
		        		case "Runtime Error!":	{        			
		        			problems.get(0).setRe(problems.get(0).getRe()+1);
		        			break;
		    			}  			        		
	        		}
	        		if (status.get(0).getResult()=="Accepted!"){
	        			crank.get(0).setLastS(minute);
	        			if(crank.get(0).getSolvedP().indexOf(String.valueOf(status.get(0).getProblem_id()))==-1){
	        				crank.get(0).setSolvedC(crank.get(0).getSolvedC()+1);
	        				crank.get(0).setSolvedP(crank.get(0).getSolvedP()+status.get(0).getProblem_id()+"c"+minute+"c");
	        				if(problems.get(0).getAc()==1){//fb
	        					crank.get(0).setFb(crank.get(0).getFb()+status.get(0).getProblem_id()+"c");
	        				}
	        				crank.get(0).setPenatly(calPenatly(crank.get(0).getSolvedP(),crank.get(0).getUnsolvedP(),minute));
	        			}
	        			
			   		}else{
	        			//否则没解决题目加上题目号和一个分割线| 
	        			if(crank.get(0).getUnsolvedP().indexOf(String.valueOf(status.get(0).getProblem_id()))==-1)
	        				crank.get(0).setUnsolvedP(crank.get(0).getUnsolvedP()+status.get(0).getProblem_id()+"c1c");
	        			else
	        				crank.get(0).setUnsolvedP(handleStr(crank.get(0).getUnsolvedP(),status.get(0).getProblem_id()));
			   		}
					
			  
			   		
	        		
	        		
	        		
	        		//更新数据库中用户数据,总共4项
	        		String[] crankargs={"solvedC","penatly","solvedP","unsolvedP","lastS","fb"};
	
	        		baseDao.update(crankargs, crank.get(0));
	        		
	        		//更新数据库中问题的数据
	        		String[] proargs={"ac","pe","wa","tle","ce","re","total"};
	        		baseDao.update(proargs, problems.get(0));
		                
	                }catch(IOException | InterruptedException e){
	                	e.printStackTrace();
	                }
				}
			}
			try {
				Thread.sleep(3000);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
		}
		
	}
	
	private long calPenatly(String solvedP, String unsolvedP, long minute) {
		long ret=minute;
		String  sol[]=solvedP.split("c");
		String  uns[]=unsolvedP.split("c");
		for (int i = 0; i < sol.length; i+=2) {
			for(int j=0;j<uns.length;j+=2)
			if(sol[i].equals(uns[j])){
				ret+=Long.parseLong(uns[j+1])*20;
			}
		}			
		return ret;
	}

	public static void main(String[] args) {
		JudgeContestBin daoTest = new JudgeContestBin();
		new Thread(daoTest).start();
	}

}
