package com.techvariable.network.Service.Impl;

import com.techvariable.network.Service.UserService;
import com.techvariable.network.Service.helper.BusUtil;
import com.techvariable.network.Service.helper.EmailUtil;
import com.techvariable.network.Service.helper.SmsUtil;
import com.techvariable.network.model.*;
import com.techvariable.network.repository.*;
import com.techvariable.network.util.MessageDigestUtil;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;

@Service
@Slf4j
public class UserServiceImpl implements UserService {

  @Autowired
  private UserRepository userRepository;

  @Override
  public User loadUserByUserNameAll(String userName) {
    return userRepository.getUserByUserNameAll(userName);
  }

}
