package com.techvariable.network.controller;


import com.techvariable.network.Service.UserService;
import com.techvariable.network.model.*;
import com.techvariable.network.repository.UserRepository;
import com.techvariable.network.utility.ControllerResponse;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.scheduling.annotation.EnableAsync;
import org.springframework.security.authentication.BadCredentialsException;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.web.bind.annotation.*;
import com.techvariable.network.config.JWTTokenUtil;
import javax.annotation.PostConstruct;

import java.util.Arrays;
import java.util.List;
import java.util.concurrent.Callable;

@SpringBootApplication
@ComponentScan(basePackages = {"com.techvariable"})
@RestController
@CrossOrigin
@Slf4j
@EnableAsync
public class UserController {

    @Autowired
    private UserService userService;

    @Autowired
    private UserRepository userRepository;



    @PostMapping(value="deleteUser" , consumes = "application/json", produces="application/json;charset=UTF-8")
    public Callable<ControllerResponse> deleteUser(@RequestBody User user){
       return () ->{
           try{
               String userName = user.getUserName();
               User users = userService.loadUserByUserNameAll(userName);
               ControllerResponse controllerResponse = new ControllerResponse<>();

               String status = users.getStatus();
               System.out.println(status);
               System.out.println("I'm outside");
               if (status.equalsIgnoreCase("inactive")) {
                   System.out.println("I'm here");
                   controllerResponse.setSuccess(false);
                   controllerResponse.setErrorMessage(userName + " already deleted");
                   controllerResponse.setErrorMessages(Arrays.asList(userName + " already deleted"));
                   controllerResponse.setData(null);

                   return controllerResponse;
               }

               if(user == null){
                   controllerResponse.setSuccess(false);
                   controllerResponse.setErrorMessage(userName + " not found");
                   controllerResponse.setErrorMessages(Arrays.asList(userName + " not found"));
                   controllerResponse.setData(null);

                   return controllerResponse;
               }

               users.setStatus("inactive");
               userRepository.save(users);
               controllerResponse.setSuccess(true);
               controllerResponse.setMessage(userName + " deleted successfully");
               controllerResponse.setData("User deleted successfully");

               return controllerResponse;

           }catch(Exception ex){
               ControllerResponse controllerResponse = new ControllerResponse<>();
               controllerResponse.setErrorMessage(ex.toString());
               controllerResponse.setSuccess(false);
               return controllerResponse;
           }
       };
    }

}
