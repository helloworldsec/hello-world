package server;



import java.rmi.RemoteException;

public class AdderRemote implements Adder {
	AdderRemote()throws RemoteException{  
	super();  
}
public int add(int x,int y){return x+y;}  

}  